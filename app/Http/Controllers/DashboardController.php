<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Table;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index() 
    { 
        $totalStaff = User::whereIn('role', ['waiter', 'cook', 'manager', 'cashier', 'delivery', 'restaurant manager'])->count();
        $activeOrders = \App\Models\Order::whereIn('status', ['pending', 'preparing', 'ready'])->count();
        $todayRevenue = \App\Models\Order::where('status', 'delivered')->whereDate('created_at', date('Y-m-d'))->sum('total_price');
        $availableTablesCount = Table::where('status', 'available')->count();
        $totalTables = Table::count();

        $recentOrders = \App\Models\Order::latest()->take(5)->get();
        $todayReservations = Reservation::whereDate('reservation_date', date('Y-m-d'))->orderBy('reservation_time')->get();
        $upcomingReservations = Reservation::where('reservation_date', '>', date('Y-m-d'))->orderBy('reservation_date')->orderBy('reservation_time')->take(4)->get();

        return view('dashboard.index', compact(
            'totalStaff', 'activeOrders', 'todayRevenue', 'availableTablesCount', 'totalTables',
            'recentOrders', 'todayReservations', 'upcomingReservations'
        )); 
    }
    
    /**
     * Display the reservations view with real data and stats.
     */
    public function reservations() 
    { 
        $clients = User::where('role', 'client')->get();
        $tables = Table::all();
        $reservations = Reservation::with(['table', 'user'])->latest()->get();
        
        // Calculate Stats
        $totalRes = Reservation::count();
        $confirmedRes = Reservation::where('status', 'confirmed')->count();
        $pendingRes = Reservation::where('status', 'pending')->count();
        $todayGuests = Reservation::where('reservation_date', date('Y-m-d'))->sum('guest_count');

        return view('dashboard.reservations', compact('clients', 'tables', 'reservations', 'totalRes', 'confirmedRes', 'pendingRes', 'todayGuests')); 
    }
    
    /**
     * Display the tables view with filtering capabilities.
     */
    public function tables(Request $request) 
    { 
        $query = Table::query();

        // Apply Category Filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tables = $query->get();
        
        return view('dashboard.tables', compact('tables')); 
    }
    
    /**
     * Display the services view with data from MongoDB.
     */
    public function services() 
    { 
        $meals = Service::where('type', 'meal')->get();
        $drinks = Service::where('type', 'drink')->get();
        
        return view('dashboard.services', compact('meals', 'drinks')); 
    }
    /**
     * Display the events view with all scheduled occasions.
     */
    public function events() 
    { 
        $events = \App\Models\Event::latest()->get();
        return view('dashboard.events', compact('events')); 
    }
    public function gallery() 
    { 
        $images = \App\Models\Gallery::latest()->get();
        return view('dashboard.gallery', compact('images')); 
    }
    public function reports() 
    { 
        $reports = \App\Models\Report::with('creator')->latest()->get();
        
        $totalSales = \App\Models\Sale::sum('amount');
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = User::where('role', 'client')->count();
        $totalReservations = Reservation::count();

        return view('dashboard.reports', compact('reports', 'totalSales', 'totalOrders', 'totalCustomers', 'totalReservations')); 
    }

    /**
     * Print a summary report.
     */
    public function printReport(Request $request)
    {
        $totalSales = \App\Models\Sale::sum('amount');
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = User::where('role', 'client')->count();
        $totalReservations = Reservation::count();
        
        $recentSales = \App\Models\Sale::latest()->take(20)->get();

        return view('dashboard.print-report', compact('totalSales', 'totalOrders', 'totalCustomers', 'totalReservations', 'recentSales'));
    }

    public function profile() { return view('dashboard.profile'); }
    public function orders() { return view('dashboard.orders'); }
    public function myOrders() 
    { 
        $user = Auth::user();
        $query = \App\Models\Order::with(['table', 'user']);
        
        if ($user->role === 'client') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'waiter') {
            $query->whereIn('status', ['ready', 'collected', 'served']);
        } elseif ($user->role === 'cook') {
            $query->whereIn('status', ['confirmed', 'preparing', 'ready']);
        } elseif ($user->role === 'delivery') {
            $query->whereIn('status', ['ready', 'collected', 'out for delivery', 'delivered']);
        } elseif (str_contains($user->role, 'manager')) {
            // Managers see all relevant orders
            $query->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready', 'collected', 'out for delivery', 'served', 'delivered', 'completed']);
        }

        $orders = $query->latest()->get();
        return view('dashboard.my-orders', compact('orders')); 
    }
    public function cashier() 
    { 
        $completedOrders = \App\Models\Order::where('status', 'completed')->get();
        $sales = \App\Models\Sale::latest()->get();
        
        $todaySalesTotal = \App\Models\Sale::whereDate('created_at', date('Y-m-d'))->sum('amount');
        $todayTransactions = \App\Models\Sale::whereDate('created_at', date('Y-m-d'))->count();
        $cashPayments = \App\Models\Sale::whereDate('created_at', date('Y-m-d'))->where('payment_method', 'Cash')->count();
        $cardPayments = \App\Models\Sale::whereDate('created_at', date('Y-m-d'))->where('payment_method', 'Card')->count();

        return view('dashboard.cashier', compact('completedOrders', 'sales', 'todaySalesTotal', 'todayTransactions', 'cashPayments', 'cardPayments')); 
    }

    public function storeSale(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        $order = \App\Models\Order::find($request->order_id);
        
        \App\Models\Sale::create([
            'order_id' => $request->order_id,
            'items' => $order ? $order->items_summary : 'Items from ' . $request->order_id,
            'amount' => (float)$request->amount,
            'payment_method' => $request->payment_method,
            'cashier_id' => Auth::id(),
        ]);

        // Mark the order as fully processed/paid if needed
        if ($order) {
            $order->status = 'completed'; // or 'paid' if we had that status
            $order->save();
        }

        return redirect()->back()->with('success', 'Sale registered successfully!');
    }
    /**
     * Display the staff accounts view with real data.
     */
    public function staffAccounts() 
    { 
        $staffMembers = User::whereIn('role', ['waiter', 'cook', 'manager', 'cashier', 'delivery', 'restaurant manager'])->latest()->get()->map(function($user) {
            $user->id = (string)$user->_id;
            return $user;
        });
        
        $totalStaff = $staffMembers->count();
        $activeStaff = $staffMembers->where('status', 'Active')->count();
        $inactiveStaff = $staffMembers->where('status', 'Inactive')->count();

        return view('dashboard.staff-accounts', compact('staffMembers', 'totalStaff', 'activeStaff', 'inactiveStaff')); 
    }

    /**
     * Display the user (client) accounts view with real data.
     */
    public function userAccounts() 
    { 
        $userMembers = User::whereIn('role', ['client'])->latest()->get()->map(function($user) {
            $user->id = (string)$user->_id;
            return $user;
        });
        
        $totalUsers = $userMembers->count();
        $activeUsers = $userMembers->where('status', 'Active')->count();
        $inactiveUsers = $userMembers->where('status', 'Inactive')->count();

        return view('dashboard.user-accounts', compact('userMembers', 'totalUsers', 'activeUsers', 'inactiveUsers')); 
    }

    /**
     * Store a newly created account (Staff or Client).
     */
    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $profilePicture = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profiles', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => strtolower($request->role),
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicture,
            'status' => 'Active',
            'is_2fa_enabled' => false,
        ]);

        return redirect()->back()->with('success', 'Account created successfully!');
    }

    /**
     * Update an existing account.
     */
    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string',
            'role' => 'required|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => strtolower($request->role),
        ];

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    /**
     * Delete an account.
     */
    public function destroyAccount($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->delete();

        return redirect()->back()->with('success', 'Account deleted successfully!');
    }

    /**
     * Toggle account status (Active/Inactive).
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return response()->json(['success' => true, 'status' => $user->status]);
    }

    /**
     * Toggle 2FA status.
     */
    public function toggle2FA($id)
    {
        $user = User::findOrFail($id);
        $user->is_2fa_enabled = !$user->is_2fa_enabled;
        $user->save();

        return response()->json(['success' => true, 'is_2fa_enabled' => $user->is_2fa_enabled]);
    }
    
    /**
     * Display the notifications view with inbox and sent messages.
     */
    public function notifications() 
    { 
        $user = Auth::user();
        
        // Fetch notifications received by the current user
        $inbox = Notification::with('sender')->where('receiver_id', $user->id)->latest()->get();
        
        // Fetch notifications sent by the current user
        $sent = Notification::with('receiver')->where('sender_id', $user->id)->latest()->get();
        
        // Fetch all other users to allow sending messages
        $users = User::where('_id', '!=', $user->id)->get();

        return view('dashboard.notifications', compact('inbox', 'sent', 'users')); 
    }

    /**
     * Display the settings view.
     */
    public function settings()
    {
        $settings = [
            'max_login_attempts' => \App\Models\Setting::get('max_login_attempts', 3),
            'session_timeout' => \App\Models\Setting::get('session_timeout', 30),
            'smtp_server' => \App\Models\Setting::get('smtp_server', env('MAIL_HOST')),
            'smtp_port' => \App\Models\Setting::get('smtp_port', env('MAIL_PORT')),
            'email_address' => \App\Models\Setting::get('email_address', env('MAIL_FROM_ADDRESS')),
            'email_notifications' => \App\Models\Setting::get('email_notifications', true),
        ];
        return view('dashboard.settings', compact('settings'));
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'max_login_attempts' => 'required|integer|min:1',
            'session_timeout' => 'required|integer|min:1',
            'smtp_server' => 'nullable|string',
            'smtp_port' => 'nullable|integer',
            'email_address' => 'nullable|email',
            'email_notifications' => 'nullable|boolean',
        ]);

        foreach ($data as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        // Also handle the checkbox which might not be in the request if unchecked
        if (!$request->has('email_notifications')) {
            \App\Models\Setting::set('email_notifications', false);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
