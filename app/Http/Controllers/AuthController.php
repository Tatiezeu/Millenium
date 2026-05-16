<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function login()
    {
        return view('Auth.login');
    }

    /**
     * Display the registration view.
     */
    public function register()
    {
        return view('Auth.register');
    }

    /**
     * Handle a registration request for the application.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle profile picture upload if present
        $profilePicture = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Generate a 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Create the user record in MongoDB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicture,
            'status' => 'Inactive',
            'verification_code' => $verificationCode,
        ]);

        // Auto-login the user after registration
        Auth::login($user);

        // Flash the code for testing purposes (simulating an email)
        session(['test_verification_code' => $verificationCode]);

        // Redirect to account verification view
        return redirect()->route('account.verify')->with('info', 'Registration successful! Please verify your account.');
    }

    /**
     * Show the account verification view.
     */
    public function showVerifyAccount()
    {
        if (!Auth::check() || Auth::user()->status === 'Active') {
            return redirect('/dashboard');
        }
        return view('Auth.verify-account');
    }

    /**
     * Handle account verification code.
     */
    public function confirmVerification(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        if ($user->verification_code == $request->code) {
            $user->status = 'Active';
            $user->verification_code = null;
            $user->is_2fa_enabled = false; // 2FA is disabled by default
            $user->save();

            if ($user->role === 'client') {
                return redirect('/')->with('welcome', 'Account verified! Welcome to Millenium.');
            }

            return redirect('/dashboard')->with('welcome', 'Account verified! Welcome to Millenium.');
        }

        return back()->withErrors(['code' => 'The verification code is incorrect.']);
    }

    /**
     * Handle an authentication attempt.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validate credentials input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $maxAttempts = (int) \App\Models\Setting::get('max_login_attempts', 3);
        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in $seconds seconds.",
            ])->onlyInput('email');
        }

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            $user = Auth::user();

            // Check if account is active
            if ($user->status === 'Inactive') {
                return redirect()->route('account.verify')->with('info', 'Please verify your account to continue.');
            }

            // Check if 2FA is enabled for this user
            if ($user->is_2fa_enabled) {
                // Generate a 6-digit code
                $code = rand(100000, 999999);
                $user->two_factor_code = $code;
                $user->two_factor_expires_at = now()->addMinutes(10);
                $user->save();

                // Send the email
                try {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerifyEmail($code));
                } catch (\Exception $e) {
                    // Log the error if mail fails but don't block login for now or handle appropriately
                    \Illuminate\Support\Facades\Log::error('Failed to send 2FA email: ' . $e->getMessage());
                }

                // Put a flag in session that the user is pending 2FA verification
                $request->session()->put('2fa_pending', true);

                return redirect()->route('2fa.verify');
            }

            $request->session()->regenerate();

            // Redirect based on role: Clients go to welcome page, staff to dashboard
            if ($user->role === 'client') {
                return redirect('/')->with('welcome', 'Welcome back, ' . $user->name . '!');
            }

            // Redirect to dashboard with a personalized welcome message
            return redirect('/dashboard')->with('welcome', 'Welcome back, ' . $user->name . '!');
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the 2FA verification view.
     */
    public function showVerify()
    {
        if (!Auth::check() || !session('2fa_pending')) {
            return redirect('/login');
        }
        return view('auth.verify');
    }

    /**
     * Handle 2FA code verification.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        if ($user->two_factor_code == $request->code && now()->lt($user->two_factor_expires_at)) {
            // Clear the code and the session flag
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();

            $request->session()->forget('2fa_pending');
            $request->session()->regenerate();

            return redirect('/dashboard')->with('welcome', 'Verification successful! Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
    }

    /**
     * Log the user out of the application.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
