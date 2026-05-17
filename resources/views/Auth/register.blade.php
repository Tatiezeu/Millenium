{-- Register View --}
{-- This view handles the display and user interaction for Register. --}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Begin Your Journey | Millenium</title>
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
      background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070') center/cover no-repeat;
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
      max-width: 480px;
      animation: fadeIn 0.8s ease-out;
    }

    .logo {
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--primary);
      font-family: 'Playfair Display', serif;
      margin-bottom: 2rem;
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
      margin-bottom: 2rem;
      font-size: 1.05rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem;
      margin-bottom: 1.2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-group.full-width { grid-column: span 2; }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-light);
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      padding: 0.9rem 1.1rem;
      border: 1.5px solid #EAEAEA;
      border-radius: 12px;
      font-size: 0.95rem;
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
      font-size: 0.75rem;
      margin-top: 0.4rem;
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
      font-size: 1.1rem;
      padding: 0.3rem;
    }

    .checkbox-group {
      display: flex;
      align-items: flex-start;
      gap: 0.8rem;
      margin-bottom: 2rem;
    }

    .checkbox-group input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-top: 3px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .checkbox-group label {
      font-size: 0.9rem;
      color: var(--text-light);
      cursor: pointer;
      line-height: 1.4;
    }

    .checkbox-group a {
      color: var(--primary);
      font-weight: 700;
      text-decoration: underline;
    }

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
    }

    .btn:hover:not(:disabled) {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(139,28,58,0.35);
      background: var(--primary-dark);
    }

    .btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .btn .spinner {
      width: 22px; height: 22px; border: 3px solid rgba(255,255,255,0.3);
      border-top: 3px solid var(--white); border-radius: 50%;
      animation: spin 0.8s linear infinite; display: none;
    }
    .btn.loading .spinner { display: block; }
    .btn.loading .btn-text { display: none; }

    .login-link {
      text-align: center;
      margin-top: 2rem;
      color: var(--text-light);
      font-size: 1rem;
    }

    .login-link a {
      color: var(--primary);
      font-weight: 700;
      transition: var(--transition);
      margin-left: 0.3rem;
    }

    .login-link a:hover { color: var(--accent); border-bottom: 2px solid var(--accent); }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 992px) {
      .auth-image { display: none; }
      .auth-form-container { padding: 4rem 1.5rem; }
      .form-wrapper { max-width: 100%; }
    }

    @media (max-width: 600px) {
      .form-grid { grid-template-columns: 1fr; gap: 0; }
      .form-group.full-width { grid-column: span 1; }
    }

    @media (max-width: 480px) {
      .auth-form-container { padding: 2.5rem 1.2rem; }
      .form-header h1 { font-size: 2rem; }
      .form-control { padding: 0.8rem 1rem; }
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
     * Initialize and check for session flash messages
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
    <!-- Left Side: Gastronomy Image -->
    <div class="auth-image">
      <div class="image-content">
        <h2>A Masterpiece on Every Plate.</h2>
        <p>Join the Millenium elite. Experience seamless dining, bespoke rewards, and culinary excellence tailored to you.</p>
        <div class="image-perks">
          <span class="perk"><i class="fas fa-calendar-check"></i> Instant Booking</span>
          <span class="perk"><i class="fas fa-star"></i> Loyalty Status</span>
          <span class="perk"><i class="fas fa-gift"></i> VIP Invites</span>
        </div>
      </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="auth-form-container">
      <div class="form-wrapper">
        <a href="{{ url('/') }}" class="logo">Mille<span>nium</span></a>
        <div class="form-header">
          <h1>Create Account</h1>
          <p>Join our refined culinary community.</p>
        </div>

        <!-- Registration Form with File Upload Support -->
        <form id="registerForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group full-width">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
            @error('name') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
          </div>

          <div class="form-group full-width">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*">
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="you@email.com" value="{{ old('email') }}" required>
              @error('email') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" class="form-control" placeholder="+237 ..." value="{{ old('phone') }}" required>
              @error('phone') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-wrapper">
                <input type="password" id="password" name="password" class="form-control" placeholder="Min. 8 chars" required>
                <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                  <i class="far fa-eye"></i>
                </button>
              </div>
              @error('password') <span class="error-message" style="display:block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="confirmPassword">Confirm</label>
              <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
            </div>
          </div>

          <div class="checkbox-group">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I accept the Millenium <a href="#">Terms of Excellence</a> and <a href="#">Privacy Commitment</a></label>
          </div>

          <button type="submit" class="btn" id="submitBtn">
            <span class="spinner"></span>
            <span class="btn-text">Begin Your Experience</span>
          </button>
        </form>

        <p class="login-link">Already a member? <a href="{{ url('/login') }}">Sign In</a></p>
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
    const form = document.getElementById('registerForm');
    const inputs = {
      fullName: document.getElementById('fullName'),
      email: document.getElementById('email'),
      phone: document.getElementById('phone'),
      password: document.getElementById('password'),
      confirmPassword: document.getElementById('confirmPassword'),
      terms: document.getElementById('terms')
    };
    const submitBtn = document.getElementById('submitBtn');

    // Validation rules
    const validators = {
      fullName: (val) => val.trim().length >= 2,
      email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      phone: (val) => val.trim().length >= 8,
      password: (val) => val.length >= 8,
      confirmPassword: (val) => val === inputs.password.value && val.length > 0,
      terms: (checked) => checked
    };

    /**
     * Validate a specific field and update UI
     */
    function validateField(input, key) {
      const group = input.closest('.form-group') || input.closest('.checkbox-group');
      const isValid = key === 'terms' ? validators[key](input.checked) : validators[key](input.value);
      
      input.classList.remove('error', 'success');
      if (isValid) {
        input.classList.add('success');
        if (group) group.classList.remove('error');
      } else if (input.value !== '' || input === inputs.terms) {
        input.classList.add('error');
        if (group) group.classList.add('error');
      }
      return isValid;
    }

    // Event listeners for real-time feedback
    Object.keys(inputs).forEach(key => {
      inputs[key].addEventListener('input', () => {
        if (inputs[key].value || key === 'terms') validateField(inputs[key], key);
      });
      inputs[key].addEventListener('blur', () => validateField(inputs[key], key));
    });

    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = btn.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        btn.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
      });
    });

    // Form submission handler
    form.addEventListener('submit', (e) => {
      let allValid = true;
      Object.keys(inputs).forEach(key => {
        if (!validateField(inputs[key], key)) allValid = false;
      });

      if (!allValid) {
        e.preventDefault();
        return;
      }

      // Show loading spinner
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