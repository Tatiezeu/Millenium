<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
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
      background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070') center/cover no-repeat;
      display: flex;
      align-items: flex-end;
      padding: 4rem;
    }

    .auth-image::before {
      content: '';
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(to top, rgba(106,18,42,0.85) 0%, rgba(0,0,0,0.2) 100%);
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
    }

    .image-perks {
      margin-top: 2rem;
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
      max-width: 460px;
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
      font-size: 2.2rem;
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

    .input-wrapper {
      position: relative;
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
    }

    .checkbox-group a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: underline;
    }

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
    }

    .btn:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(139,28,58,0.4);
    }

    .btn:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .btn .spinner {
      width: 20px;
      height: 20px;
      border: 2px solid rgba(255,255,255,0.3);
      border-top: 2px solid var(--white);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }

    .btn.loading .spinner { display: block; }
    .btn.loading .btn-text { display: none; }

    .login-link {
      text-align: center;
      margin-top: 2rem;
      color: var(--text-light);
    }

    .login-link a {
      color: var(--primary);
      font-weight: 600;
      transition: var(--transition);
    }

    .login-link a:hover { color: var(--accent); }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* Responsive */
    @media (max-width: 992px) {
      .auth-image { display: none; }
      .auth-form-container { padding: 4rem 1.5rem; }
      .form-wrapper { max-width: 100%; }
    }

    @media (max-width: 480px) {
      .auth-form-container { padding: 2rem 1rem; }
      .form-header h1 { font-size: 1.8rem; }
      .form-control { padding: 0.8rem; }
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <!-- Left Side: Attractive Food Image -->
    <div class="auth-image">
      <div class="image-content">
        <h2>Your Next Favorite Meal Awaits</h2>
        <p>Join our community to unlock seamless reservations, personalized recommendations, and a rewards program that celebrates your palate.</p>
        <div class="image-perks">
          <span class="perk"><i class="fas fa-calendar-check"></i> Skip the Wait</span>
          <span class="perk"><i class="fas fa-star"></i> Earn Rewards</span>
          <span class="perk"><i class="fas fa-gift"></i> Exclusive Offers</span>
          <span class="perk"><i class="fas fa-utensils"></i> Save Favorites</span>
        </div>
      </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="auth-form-container">
      <div class="form-wrapper">
        <a href="index.html" class="logo">Lumi<span>ère</span></a>
        <div class="form-header">
          <h1>Create Account</h1>
          <p>Start your culinary journey with us today.</p>
        </div>

        <form id="registerForm" novalidate>
          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" class="form-control" placeholder="e.g. Jordan Smith" required>
            <span class="error-message">Please enter your full name.</span>
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" class="form-control" placeholder="you@example.com" required>
            <span class="error-message">Please enter a valid email address.</span>
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" class="form-control" placeholder="(555) 123-4567" required>
            <span class="error-message">Please enter a valid phone number.</span>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <input type="password" id="password" class="form-control" placeholder="Create a secure password" required>
              <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                <i class="far fa-eye"></i>
              </button>
            </div>
            <span class="error-message">Password must be at least 8 characters.</span>
          </div>

          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" class="form-control" placeholder="Repeat your password" required>
            <span class="error-message">Passwords do not match.</span>
          </div>

          <div class="checkbox-group">
            <input type="checkbox" id="terms" required>
            <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
          </div>

          <button type="submit" class="btn" id="submitBtn">
            <span class="spinner"></span>
            <span class="btn-text">Create Account</span>
          </button>
        </form>

        <p class="login-link">Already have an account? <a href="{{ url('/login') }}">Sign in here</a></p>
      </div>
    </div>
  </div>

  <script>
    // Form Validation & Submission Simulation
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

    // Validation Rules
    const validators = {
      fullName: (val) => val.trim().length >= 2,
      email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
      phone: (val) => /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/.test(val),
      password: (val) => val.length >= 8,
      confirmPassword: (val) => val === inputs.password.value && val.length > 0,
      terms: (checked) => checked
    };

    function validateField(input, validatorKey) {
      const group = input.closest('.form-group');
      const isValid = validatorKey === 'terms' ? validators[validatorKey](input.checked) : validators[validatorKey](input.value);
      
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

    // Real-time validation on blur/input
    Object.keys(inputs).forEach(key => {
      if (key === 'terms') {
        inputs[key].addEventListener('change', () => validateField(inputs[key], key));
      } else {
        inputs[key].addEventListener('input', () => {
          if (inputs[key].value) validateField(inputs[key], key);
        });
        inputs[key].addEventListener('blur', () => validateField(inputs[key], key));
      }
    });

    // Password Toggle
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = btn.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        btn.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
      });
    });

    // Form Submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let allValid = true;
      Object.keys(inputs).forEach(key => {
        if (!validateField(inputs[key], key)) allValid = false;
      });

      if (!allValid) return;

      // Simulate loading
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;

      setTimeout(() => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        submitBtn.querySelector('.btn-text').textContent = 'Account Created!';
        submitBtn.style.background = 'var(--success)';
        
        // Redirect simulation
        setTimeout(() => {
          window.location.href = 'login.html';
        }, 1500);
      }, 2000);
    });
  </script>
</body>
</html>