<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Back | Millenium</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #8B1C3A;
      --primary-dark: #6A122A;
      --accent: #D4A574;
      --bg: #FAF8F5;
      --text: #1A1A1A;
      --text-light: #555;
      --white: #FFFFFF;
      --error: #E53E3E;
      --success: #38A169;
      --shadow: 0 10px 40px rgba(0,0,0,0.1);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; min-height: 100vh; }

    h1, h2, h3 { font-family: 'Playfair Display', serif; font-weight: 700; line-height: 1.2; }
    a { text-decoration: none; color: inherit; }

    .auth-container {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    /* Left Side: Image */
    .auth-image {
      flex: 1.2;
      position: relative;
      background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070') center/cover no-repeat;
      display: flex;
      align-items: flex-end;
      padding: 4rem;
    }

    .auth-image::before {
      content: '';
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(to top, rgba(106,18,42,0.9) 0%, rgba(0,0,0,0.2) 100%);
    }

    .image-content {
      position: relative;
      z-index: 2;
      color: var(--white);
      max-width: 500px;
    }

    .image-content h2 {
      font-size: 3rem;
      margin-bottom: 1rem;
      font-weight: 800;
    }

    .image-content p {
      font-size: 1.2rem;
      opacity: 0.9;
      line-height: 1.7;
      margin-bottom: 2rem;
    }

    .image-perks {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .perk {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(12px);
      padding: 0.8rem 1.5rem;
      border-radius: 50px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .perk i { color: var(--accent); }

    /* Right Side: Form */
    .auth-form-container {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 2rem;
      background: var(--white);
    }

    .form-wrapper {
      width: 100%;
      max-width: 440px;
      animation: fadeIn 0.8s ease-out;
    }

    .logo {
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--primary);
      font-family: 'Playfair Display', serif;
      margin-bottom: 2.5rem;
      display: inline-block;
    }

    .logo span { color: var(--accent); }

    .form-header h1 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      color: var(--primary);
    }

    .form-header p {
      color: var(--text-light);
      margin-bottom: 2.5rem;
      font-size: 1.05rem;
    }

    .form-group {
      margin-bottom: 1.8rem;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.6rem;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-light);
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      padding: 1rem 1.2rem;
      border: 1.5px solid #EAEAEA;
      border-radius: 12px;
      font-size: 1rem;
      font-family: inherit;
      transition: var(--transition);
      background: #FDFDFD;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(139,28,58,0.05);
    }

    .form-control.error { border-color: var(--error); }
    .form-control.success { border-color: var(--success); }

    .error-message {
      color: var(--error);
      font-size: 0.8rem;
      margin-top: 0.5rem;
      display: none;
      font-weight: 500;
    }

    .form-group.error .error-message { display: block; }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-light);
      cursor: pointer;
      font-size: 1.2rem;
      padding: 0.3rem;
      transition: var(--transition);
    }

    .toggle-password:hover { color: var(--primary); }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2.5rem;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-size: 0.95rem;
      color: var(--text-light);
      cursor: pointer;
    }

    .checkbox-label input {
      width: 18px;
      height: 18px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .forgot-link {
      color: var(--primary);
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .forgot-link:hover { color: var(--accent); }

    .btn {
      width: 100%;
      padding: 1.1rem;
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      background: var(--primary);
      color: var(--white);
      box-shadow: 0 8px 25px rgba(139,28,58,0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
      margin-bottom: 2rem;
    }

    .btn:hover:not(:disabled) {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(139,28,58,0.35);
      background: var(--primary-dark);
    }

    .btn:active { transform: translateY(-1px); }

    .btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .btn .spinner {
      width: 22px; height: 22px; border: 3px solid rgba(255,255,255,0.3);
      border-top: 3px solid var(--white); border-radius: 50%;
      animation: spin 0.8s linear infinite; display: none;
    }
    .btn.loading .spinner { display: block; }
    .btn.loading .btn-text { display: none; }

    .divider {
      display: flex;
      align-items: center;
      gap: 1.2rem;
      margin-bottom: 2rem;
    }

    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1.5px; background: #F0F0F0;
    }
    .divider span {
      color: var(--text-light); font-size: 0.9rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.05em;
    }

    .social-btns {
      display: flex;
      gap: 1.2rem;
      margin-bottom: 2.5rem;
    }

    .social-btn {
      flex: 1;
      padding: 0.9rem;
      border: 1.5px solid #F0F0F0;
      border-radius: 12px;
      background: var(--white);
      cursor: pointer;
      font-size: 1.3rem;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-light);
    }

    .social-btn:hover {
      border-color: var(--primary);
      background: #FFF9FA;
      color: var(--primary);
      transform: translateY(-2px);
    }

    .signup-link {
      text-align: center;
      color: var(--text-light);
      font-size: 1rem;
    }

    .signup-link a {
      color: var(--primary);
      font-weight: 700;
      transition: var(--transition);
      margin-left: 0.3rem;
    }

    .signup-link a:hover { color: var(--accent); border-bottom: 2px solid var(--accent); }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 1200px) {
      .auth-image { padding: 3rem; }
      .image-content h2 { font-size: 2.5rem; }
    }

    @media (max-width: 992px) {
      .auth-image { display: none; }
      .auth-form-container { padding: 4rem 1.5rem; }
      .form-wrapper { max-width: 100%; }
    }
    @media (max-width: 480px) {
      .auth-form-container { padding: 3rem 1.2rem; }
      .form-header h1 { font-size: 2rem; }
      .social-btns { gap: 0.8rem; }
    }
  </style>
  <!-- Alpine.js for interactive components -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    /* Utility styles for interactive elements */
    [x-cloak] { display: none !important; }
  </style>
</head>
<body x-data="{ 
    toasts: [],
    /**
     * Display a toast notification
     */
    showToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
        setTimeout(() => {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }, 4000);
    },
    /**
     * Initialize and check for registration success messages
     */
    init() {
        @if(session('success'))
            this.showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            this.showToast('{{ session('error') }}', 'error');
        @endif
    }
}">

  <div class="auth-container">
    <!-- ... existing auth container content ... -->
    <!-- Left Side: Atmosphere Image -->
    <div class="auth-image">
      <div class="image-content">
        <h2>Refined Dining, Reimagined.</h2>
        <p>Step back into the world of Millenium. Your favorite table and seasonal delicacies are just a sign-in away.</p>
        <div class="image-perks">
          <span class="perk"><i class="fas fa-gem"></i> Priority Reservations</span>
          <span class="perk"><i class="fas fa-crown"></i> Exclusive Rewards</span>
          <span class="perk"><i class="fas fa-wine-glass"></i> Private Tastings</span>
        </div>
      </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="auth-form-container">
      <div class="form-wrapper">
        <a href="{{ url('/') }}" class="logo">Mille<span>nium</span></a>
        <div class="form-header">
          <h1>Welcome Back</h1>
          <p>Sign in to continue your journey.</p>
        </div>

        <!-- Real Authentication Form -->
        <form id="loginForm" action="{{ url('/login') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="name@email.com" value="{{ old('email') }}" required>
            @error('email') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
              <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="far fa-eye"></i>
              </button>
            </div>
            @error('password') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" id="remember" name="remember"> Remember me
            </label>
            <a href="#" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn" id="loginBtn">
            <span class="spinner"></span>
            <span class="btn-text">Sign In to Millenium</span>
          </button>
        </form>

        <div class="divider"><span>or access via</span></div>

        <!-- Social Login Options (Mock) -->
        <div class="social-btns">
          <button class="social-btn" aria-label="Login with Google"><i class="fab fa-google"></i></button>
          <button class="social-btn" aria-label="Login with Apple"><i class="fab fa-apple"></i></button>
          <button class="social-btn" aria-label="Login with Facebook"><i class="fab fa-facebook-f"></i></button>
        </div>

        <p class="signup-link">New to our table? <a href="{{ url('/register') }}">Create an Account</a></p>
      </div>
    </div>
  </div>

  <!-- Toast Notifications (Floating) -->
  <div class="fixed bottom-6 right-6 z-[200] space-y-3">
    <template x-for="toast in toasts" :key="toast.id">
      <div x-show="true" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-4 scale-95"
           x-transition:enter-end="opacity-100 translate-y-0 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95"
           class="flex items-center space-x-3 px-6 py-4 rounded-2xl shadow-2xl border backdrop-blur-md bg-white/90"
           :class="{
               'bg-green-500/90 border-green-400 text-white': toast.type === 'success',
               'bg-red-500/90 border-red-400 text-white': toast.type === 'error'
           }">
        <div class="p-1 bg-white/20 rounded-lg">
          <i :data-lucide="toast.type === 'success' ? 'check-circle' : 'alert-circle'" class="w-5 h-5 text-white"></i>
        </div>
        <p class="text-sm font-bold" x-text="toast.message"></p>
      </div>
    </template>
  </div>

  <script>
    /**
     * Frontend Validation and Form Submission logic
     */
    const form = document.getElementById('loginForm');
    const inputs = {
      email: document.getElementById('email'),
      password: document.getElementById('password')
    };
    const submitBtn = document.getElementById('loginBtn');

    // Validation rules
    const validators = {
      email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      password: (val) => val.trim().length >= 8
    };

    /**
     * Validate a specific input field
     */
    function validateField(input, key) {
      const group = input.closest('.form-group');
      const isValid = validators[key](input.value);
      input.classList.remove('error', 'success');
      
      if (isValid) {
        input.classList.add('success');
        if (group) group.classList.remove('error');
      } else if (input.value !== '') {
        input.classList.add('error');
        if (group) group.classList.add('error');
      }
      return isValid;
    }

    // Attach listeners to all inputs
    Object.keys(inputs).forEach(key => {
      inputs[key].addEventListener('input', () => {
        if (inputs[key].value) validateField(inputs[key], key);
      });
      inputs[key].addEventListener('blur', () => validateField(inputs[key], key));
    });

    // Toggle password visibility
    document.querySelector('.toggle-password').addEventListener('click', function() {
      const pwd = document.getElementById('password');
      const type = pwd.type === 'password' ? 'text' : 'password';
      pwd.type = type;
      this.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
      let valid = true;
      Object.keys(inputs).forEach(key => { if (!validateField(inputs[key], key)) valid = false; });

      if (!valid) {
        e.preventDefault();
        return;
      }

      // Show loading state
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;
    });

    // Initialize icons
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>
</body>
</html>