<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Back | Lumière</title>
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
      flex: 1;
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
      background: linear-gradient(to top, rgba(106,18,42,0.85) 0%, rgba(0,0,0,0.25) 100%);
    }

    .image-content {
      position: relative;
      z-index: 2;
      color: var(--white);
      max-width: 500px;
    }

    .image-content h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      font-weight: 800;
    }

    .image-content p {
      font-size: 1.1rem;
      opacity: 0.9;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .image-perks {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .perk {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(8px);
      padding: 0.6rem 1.2rem;
      border-radius: 50px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
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
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--primary);
      font-family: 'Playfair Display', serif;
      margin-bottom: 2rem;
      display: inline-block;
    }

    .logo span { color: var(--accent); }

    .form-header h1 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .form-header p {
      color: var(--text-light);
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .form-control {
      width: 100%;
      padding: 0.9rem 1rem;
      border: 2px solid #e2e2e2;
      border-radius: 10px;
      font-size: 1rem;
      font-family: inherit;
      transition: var(--transition);
      background: #fafafa;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(139,28,58,0.1);
    }

    .form-control.error { border-color: var(--error); }
    .form-control.success { border-color: var(--success); }

    .error-message {
      color: var(--error);
      font-size: 0.85rem;
      margin-top: 0.4rem;
      display: none;
    }

    .form-group.error .error-message { display: block; }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: calc(0.9rem + 0.7rem);
      background: none;
      border: none;
      color: var(--text-light);
      cursor: pointer;
      font-size: 1.1rem;
      padding: 0.3rem;
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      color: var(--text-light);
      cursor: pointer;
    }

    .checkbox-label input {
      width: 16px;
      height: 16px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .forgot-link {
      color: var(--primary);
      font-weight: 600;
      font-size: 0.9rem;
      transition: var(--transition);
    }

    .forgot-link:hover { color: var(--accent); text-decoration: underline; }

    .btn {
      width: 100%;
      padding: 1rem;
      border: none;
      border-radius: 10px;
      font-size: 1.05rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--white);
      box-shadow: 0 4px 15px rgba(139,28,58,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      margin-bottom: 1.5rem;
    }

    .btn:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(139,28,58,0.4);
    }

    .btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .btn .spinner {
      width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3);
      border-top: 2px solid var(--white); border-radius: 50%;
      animation: spin 0.8s linear infinite; display: none;
    }
    .btn.loading .spinner { display: block; }
    .btn.loading .btn-text { display: none; }

    .divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: #e2e2e2;
    }
    .divider span {
      color: var(--text-light); font-size: 0.9rem; font-weight: 500;
    }

    .social-btns {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .social-btn {
      flex: 1;
      padding: 0.8rem;
      border: 2px solid #e2e2e2;
      border-radius: 10px;
      background: transparent;
      cursor: pointer;
      font-size: 1.2rem;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .social-btn:hover {
      border-color: var(--primary);
      background: rgba(139,28,58,0.05);
      color: var(--primary);
    }

    .signup-link {
      text-align: center;
      color: var(--text-light);
    }

    .signup-link a {
      color: var(--primary);
      font-weight: 600;
      transition: var(--transition);
    }

    .signup-link a:hover { color: var(--accent); }

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
    @media (max-width: 480px) {
      .auth-form-container { padding: 2rem 1rem; }
      .form-header h1 { font-size: 1.8rem; }
      .form-control { padding: 0.8rem; }
      .social-btns { flex-direction: column; }
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <!-- Left Side: Different Image -->
    <div class="auth-image">
      <div class="image-content">
        <h2>Welcome Back to the Table</h2>
        <p>Access your reservations, track loyalty points, and reorder your favorite dishes with just one tap.</p>
        <div class="image-perks">
          <span class="perk"><i class="fas fa-bell"></i> Instant Notifications</span>
          <span class="perk"><i class="fas fa-clock"></i> Quick Reorders</span>
          <span class="perk"><i class="fas fa-heart"></i> Dietary Preferences</span>
        </div>
      </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="auth-form-container">
      <div class="form-wrapper">
        <a href="index.html" class="logo">Mille<span>nium</span></a>
        <div class="form-header">
          <h1>Sign In</h1>
          <p>Enter your credentials to continue.</p>
        </div>

        <form id="loginForm" novalidate>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" class="form-control" placeholder="you@example.com" required>
            <span class="error-message">Please enter a valid email address.</span>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
              <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="far fa-eye"></i>
              </button>
            </div>
            <span class="error-message">Password is required.</span>
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" id="remember"> Remember me
            </label>
            <a href="#" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn" id="loginBtn">
            <span class="spinner"></span>
            <span class="btn-text">Sign In</span>
          </button>
        </form>

        <div class="divider"><span>or continue with</span></div>

        <div class="social-btns">
          <button class="social-btn" aria-label="Login with Google"><i class="fab fa-google"></i></button>
          <button class="social-btn" aria-label="Login with Apple"><i class="fab fa-apple"></i></button>
          <button class="social-btn" aria-label="Login with Facebook"><i class="fab fa-facebook-f"></i></button>
        </div>

        <p class="signup-link">Don't have an account? <a href="{{ url('/register') }}">Create one free</a></p>
      </div>
    </div>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    const inputs = {
      email: document.getElementById('email'),
      password: document.getElementById('password')
    };
    const submitBtn = document.getElementById('loginBtn');

    const validators = {
      email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      password: (val) => val.trim().length > 0
    };

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

    // Real-time validation
    Object.keys(inputs).forEach(key => {
      inputs[key].addEventListener('input', () => {
        if (inputs[key].value) validateField(inputs[key], key);
      });
      inputs[key].addEventListener('blur', () => validateField(inputs[key], key));
    });

    // Password Toggle
    document.querySelector('.toggle-password').addEventListener('click', function() {
      const pwd = document.getElementById('password');
      const type = pwd.type === 'password' ? 'text' : 'password';
      pwd.type = type;
      this.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
    });

    // Submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let valid = true;
      Object.keys(inputs).forEach(key => { if (!validateField(inputs[key], key)) valid = false; });

      if (!valid) return;

      submitBtn.classList.add('loading');
      submitBtn.disabled = true;

      // Simulate API call
      setTimeout(() => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        submitBtn.querySelector('.btn-text').textContent = 'Redirecting...';
        submitBtn.style.background = 'var(--success)';
        
        setTimeout(() => window.location.href = 'dashboard.html', 1500);
      }, 1800);
    });
  </script>
</body>
</html>