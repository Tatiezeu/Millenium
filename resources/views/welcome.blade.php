<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lumière | Fine Dining & Casual Elegance</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #8B1C3A;
      --primary-dark: #6A122A;
      --accent: #D4A574;
      --accent-light: #F5E6D3;
      --bg: #FAF8F5;
      --text: #1A1A1A;
      --text-light: #555;
      --white: #FFFFFF;
      --dark: #0f0f0f;
      --shadow: 0 10px 30px rgba(0,0,0,0.1);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; overflow-x: hidden; }
    h1, h2, h3, h4 { font-family: 'Playfair Display', serif; font-weight: 700; line-height: 1.2; }
    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }

    /* Navigation */
    .navbar {
      position: fixed; top: 0; width: 100%; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center;
      background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); z-index: 1000; border-bottom: 1px solid rgba(0,0,0,0.05); transition: var(--transition);
    }
    .logo { font-size: 2rem; font-weight: 800; color: var(--primary); font-family: 'Playfair Display', serif; }
    .logo span { color: var(--accent); }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a { font-weight: 500; color: var(--text); transition: var(--transition); position: relative; }
    .nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: var(--primary); transition: width 0.3s; }
    .nav-links a:hover::after { width: 100%; }
    .nav-links a:hover { color: var(--primary); }
    .auth-buttons { display: flex; gap: 1rem; align-items: center; }
    .btn { padding: 0.8rem 1.8rem; border-radius: 50px; font-weight: 600; cursor: pointer; transition: var(--transition); border: 2px solid transparent; font-size: 0.95rem; display: inline-block; }
    .btn-outline { border-color: var(--primary); color: var(--primary); background: transparent; }
    .btn-outline:hover { background: white; color:white; transform: translateY(-2px); }
    .btn-primary { background: linear-gradient(135deg, var(white), var(white)); color: var( white); box-shadow: 0 4px 15px rgba(139,28,58,0.3); }
    .btn-primary:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 8px 25px rgba(139,28,58,0.4); }
    .btn-accent { background: var(--accent); color: var(--dark); }
    .btn-accent:hover { background: #c2935f; transform: translateY(-2px); }
    .menu-toggle { display: none; font-size: 1.5rem; cursor: pointer; color: var(--text); }

    /* Hero Carousel */
    .hero { position: relative; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
    .carousel { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }
    .carousel-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease-in-out; background-size: cover; background-position: center; }
    .carousel-slide.active { opacity: 1; }
    .carousel-slide::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.65)); }
    .carousel-indicators { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }
    .indicator { width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: var(--transition); border: 2px solid transparent; }
    .indicator.active { background: var(--accent); transform: scale(1.3); border-color: var(--white); }
    .hero-content { position: relative; z-index: 5; text-align: center; padding: 0 5%; max-width: 900px; color: var(--white); animation: fadeInUp 1s ease-out; }
    .hero-badge { display: inline-block; background: rgba(212,165,116,0.25); border: 1px solid var(--accent); color: var(--white); padding: 0.5rem 1.5rem; border-radius: 50px; font-size: 0.9rem; font-weight: 600; margin-bottom: 1.5rem; letter-spacing: 1px; text-transform: uppercase; }
    .hero h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 1.2rem; text-shadow: 0 2px 15px rgba(0,0,0,0.4); font-weight: 800; }
    .hero p { font-size: clamp(1.1rem, 2vw, 1.35rem); margin-bottom: 2.5rem; opacity: 0.95; max-width: 650px; margin-left: auto; margin-right: auto; font-weight: 300; }
    .hero-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

    /* Section Styling */
    section { padding: 6rem 5%; }
    .section-header { text-align: center; margin-bottom: 4rem; }
    .section-subtitle { color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; margin-bottom: 0.8rem; display: block; }
    .section-title { font-size: clamp(2rem, 4vw, 3rem); color: var(--dark); margin-bottom: 1rem; position: relative; display: inline-block; }
    .section-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 2px; }
    .section-desc { font-size: 1.15rem; color: var(--text-light); max-width: 600px; margin: 1.5rem auto 0; }

    /* About/Welcome */
    .welcome { background: var(--white); }
    .welcome-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; max-width: 1200px; margin: 0 auto; }
    .welcome-img { width: 100%; height: 450px; object-fit: cover; border-radius: 20px; box-shadow: var(--shadow); }
    .welcome-text h3 { font-size: 2.2rem; margin-bottom: 1rem; color: var(--primary); }
    .welcome-text p { margin-bottom: 1.5rem; font-size: 1.05rem; line-height: 1.8; }
    .features-list { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; }
    .feature-item { display: flex; align-items: center; gap: 0.8rem; font-weight: 500; }
    .feature-item i { color: var(--accent); font-size: 1.2rem; }

    /* Menu Preview */
    .menu-preview { background: var(--bg); }
    .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .menu-card { background: var(--white); border-radius: 20px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); }
    .menu-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
    .menu-img { width: 100%; height: 220px; object-fit: cover; }
    .menu-content { padding: 1.5rem; }
    .menu-content h3 { margin-bottom: 0.5rem; font-size: 1.4rem; }
    .menu-content p { color: var(--text-light); margin-bottom: 1rem; font-size: 0.95rem; }
    .menu-price { font-weight: 700; color: var(--primary); font-size: 1.3rem; }
    .menu-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .menu-actions .btn { padding: 0.6rem 1.2rem; font-size: 0.85rem; }

    /* Experience/Why Dine */
    .experience { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: var(--white); }
    .experience .section-title { color: var(--white); }
    .experience .section-desc { color: rgba(255,255,255,0.85); }
    .exp-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .exp-card { text-align: center; padding: 2rem; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.2); transition: var(--transition); }
    .exp-card:hover { transform: translateY(-8px); background: rgba(255,255,255,0.15); }
    .exp-icon { width: 70px; height: 70px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.8rem; color: var(--dark); }
    .exp-card h3 { margin-bottom: 0.8rem; font-size: 1.4rem; }
    .exp-card p { opacity: 0.9; font-size: 0.95rem; }

    /* Customer Reviews */
    .reviews { background: var(--white); }
    .reviews-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .review-card { background: var(--bg); padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow); position: relative; transition: var(--transition); }
    .review-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
    .review-card::before { content: '\201C'; position: absolute; top: 15px; left: 25px; font-size: 5rem; color: var(--accent); opacity: 0.2; font-family: 'Playfair Display', serif; line-height: 1; }
    .stars { color: var(--accent); margin-bottom: 1rem; font-size: 1.1rem; }
    .review-text { font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem; position: relative; z-index: 1; }
    .review-author { display: flex; align-items: center; gap: 1rem; }
    .author-avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--white); font-weight: 700; }
    .author-info h4 { font-size: 1.1rem; margin-bottom: 0.2rem; }
    .author-info p { color: var(--text-light); font-size: 0.85rem; }

    /* Location & Hours */
    .location { background: var(--bg); }
    .location-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; max-width: 1200px; margin: 0 auto; }
    .map-placeholder { width: 100%; height: 400px; background: #e0e0e0; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: #888; font-size: 1.2rem; box-shadow: var(--shadow); }
    .info-block { background: var(--white); padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow); }
    .info-block h3 { font-size: 1.8rem; margin-bottom: 1.5rem; color: var(--primary); }
    .info-row { display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px dashed #ddd; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-weight: 600; }
    .info-value { color: var(--text-light); }

    /* Auth CTA Section */
    .auth-cta { background: linear-gradient(135deg, rgba(139,28,58,0.95), rgba(106,18,42,0.95)), url('https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1974'); background-size: cover; background-position: center; padding: 8rem 5%; text-align: center; color: var(--white); position: relative; }
    .auth-content { max-width: 700px; margin: 0 auto; position: relative; z-index: 1; }
    .auth-cta h2 { font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem; }
    .auth-cta p { font-size: 1.2rem; margin-bottom: 2.5rem; opacity: 0.95; }
    .auth-buttons-large { display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; }
    .auth-buttons-large .btn { padding: 1rem 2.5rem; font-size: 1.1rem; }

    /* Footer */
    footer { background: var(--dark); color: #aaa; padding: 4rem 5% 2rem; }
    .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; max-width: 1200px; margin: 0 auto 3rem; }
    .footer-col h4 { color: var(--white); margin-bottom: 1.5rem; font-size: 1.2rem; position: relative; padding-bottom: 0.8rem; }
    .footer-col h4::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: var(--accent); }
    .footer-col ul li { margin-bottom: 0.8rem; }
    .footer-col a { transition: var(--transition); }
    .footer-col a:hover { color: var(--accent); padding-left: 5px; }
    .socials { display: flex; gap: 1rem; margin-top: 1rem; }
    .socials a { width: 40px; height: 40px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: var(--transition); }
    .socials a:hover { background: var(--accent); color: var(--dark); transform: translateY(-3px); }
    .copyright { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.9rem; }

    /* Animations & Utilities */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }

    /* Responsive */
    @media (max-width: 992px) {
      .welcome-grid, .location-grid { grid-template-columns: 1fr; }
      .welcome-img { height: 350px; margin-bottom: 2rem; }
    }
    @media (max-width: 768px) {
      .menu-toggle { display: block; }
      .nav-links { position: fixed; top: 70px; right: -100%; width: 85%; max-width: 350px; height: calc(100vh - 70px); background: var(--white); flex-direction: column; align-items: flex-start; padding: 2.5rem; box-shadow: -5px 0 20px rgba(0,0,0,0.1); transition: var(--transition); }
      .nav-links.active { right: 0; }
      .auth-buttons { flex-direction: column; width: 100%; margin-top: 1.5rem; }
      .btn { width: 100%; text-align: center; }
      .features-list { grid-template-columns: 1fr; }
      .hero h1 { font-size: 2.5rem; }
      .auth-buttons-large { flex-direction: column; gap: 1rem; }
      .auth-buttons-large .btn { width: 100%; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <a href="#" class="logo">Mille<span>nium</span></a>
    <div class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></div>
    <div class="nav-links" id="navLinks">
      <a href="#menu">Menu</a>
      <a href="#experience">Experience</a>
      <a href="#reviews">Reviews</a>
      <a href="#location">Visit Us</a>
      <div class="auth-buttons">
        <a href="{{ url('/login') }}" class="btn btn-outline">Sign In</a>
        <a href="{{ url('/register') }}" class="btn btn-primary">Create Account</a>
      </div>
    </div>
  </nav>

  <!-- Hero Carousel -->
  <header class="hero">
    <div class="carousel">
      <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1974')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1550966871-3ed3c47e2ce2?q=80&w=2070')"></div>
    </div>
    <div class="hero-content">
      <div class="hero-badge">Open Daily 11AM - 11PM</div>
      <h1>Taste the Art of <span style="color: var(--accent); display: block;">Modern Dining</span></h1>
      <p>Handcrafted dishes, curated ambiance, and unforgettable moments. Reserve your table, order online, or join our rewards program today.</p>
      <div class="hero-buttons">
        <a href="#reservations" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Reserve a Table</a>
        <a href="#menu" class="btn btn-outline" style="border-color: #fff; color: #fff;"><i class="fas fa-book-open"></i> Explore Menu</a>
        <a href="{{ url('/login') }}" class="btn btn-accent"><i class="fas fa-user"></i> Sign In to Order</a>
      </div>
    </div>
    <div class="carousel-indicators">
      <div class="indicator active" data-slide="0"></div>
      <div class="indicator" data-slide="1"></div>
      <div class="indicator" data-slide="2"></div>
      <div class="indicator" data-slide="3"></div>
    </div>
  </header>

  <!-- Welcome Section -->
  <section class="welcome" id="about">
    <div class="welcome-grid">
      <img src="https://images.unsplash.com/photo-1552566626-52f8b828b5ad?q=80&w=2070" alt="Restaurant Interior" class="welcome-img fade-in">
      <div class="welcome-text fade-in">
        <span class="section-subtitle">Our Story</span>
        <h3>Where Every Meal Becomes a Memory</h3>
        <p>At Lumière, we believe dining is more than just food—it's an experience. Our chefs blend seasonal ingredients with global techniques to create dishes that surprise, comfort, and inspire. Whether you're joining us for a quick lunch, a romantic dinner, or a family celebration, we promise exceptional hospitality in every detail.</p>
        <div class="features-list">
          <div class="feature-item"><i class="fas fa-leaf"></i> Farm-to-Table Freshness</div>
          <div class="feature-item"><i class="fas fa-wine-glass"></i> Crafted Cocktail Pairings</div>
          <div class="feature-item"><i class="fas fa-mobile-alt"></i> Seamless Online Ordering</div>
          <div class="feature-item"><i class="fas fa-gift"></i> Loyalty Rewards Program</div>
        </div>
        <a href="register.html" class="btn btn-outline">Join Our Community</a>
      </div>
    </div>
  </section>

  <!-- Menu Preview -->
  <section class="menu-preview" id="menu">
    <div class="section-header fade-in">
      <span class="section-subtitle">Chef's Selection</span>
      <h2 class="section-title">Featured Dishes</h2>
      <p class="section-desc">A taste of what awaits. Order ahead or visit us to experience our full seasonal menu.</p>
    </div>
    <div class="menu-grid">
      <div class="menu-card fade-in">
        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1974" alt="Grilled Salmon" class="menu-img">
        <div class="menu-content">
          <h3>Herb-Crusted Salmon</h3>
          <p>Pan-seared Atlantic salmon with lemon dill sauce, roasted asparagus, and quinoa pilaf.</p>
          <div class="menu-actions">
            <span class="menu-price">$28</span>
            <a href="{{ url('/login') }}" class="btn btn-primary">Add to Order</a>
          </div>
        </div>
      </div>
      <div class="menu-card fade-in">
        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1981" alt="Truffle Pizza" class="menu-img">
        <div class="menu-content">
          <h3>Black Truffle Margherita</h3>
          <p>Wood-fired crust, San Marzano tomatoes, fresh mozzarella, basil, and shaved black truffle.</p>
          <div class="menu-actions">
            <span class="menu-price">$22</span>
            <a href="{{ url('/login') }}" class="btn btn-primary">Add to Order</a>
          </div>
        </div>
      </div>
      <div class="menu-card fade-in">
        <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1978" alt="Chocolate Dessert" class="menu-img">
        <div class="menu-content">
          <h3>Valrhona Chocolate Fondant</h3>
          <p>Warm dark chocolate cake with a molten center, served with vanilla bean ice cream.</p>
          <div class="menu-actions">
            <span class="menu-price">$14</span>
            <a href="{{ url('/login') }}" class="btn btn-primary">Add to Order</a>
          </div>
        </div>
      </div>
    </div>
    <div style="text-align: center; margin-top: 3rem;">
      <a href="#" class="btn btn-outline btn-large">View Full Menu</a>
    </div>
  </section>

  <!-- Experience/Why Dine -->
  <section class="experience" id="experience">
    <div class="section-header fade-in">
      <span class="section-subtitle" style="color: var(--accent)">The Lumière Experience</span>
      <h2 class="section-title">Why Guests Keep Coming Back</h2>
      <p class="section-desc">More than a meal—it's how we make you feel.</p>
    </div>
    <div class="exp-grid">
      <div class="exp-card fade-in">
        <div class="exp-icon"><i class="fas fa-utensils"></i></div>
        <h3>Seasonal Menus</h3>
        <p>Our chefs rotate dishes monthly to highlight the freshest local ingredients and global inspirations.</p>
      </div>
      <div class="exp-card fade-in">
        <div class="exp-icon"><i class="fas fa-clock"></i></div>
        <h3>Fast & Reliable Ordering</h3>
        <p>Order ahead for pickup or delivery. Your food arrives hot, fresh, and exactly as you like it.</p>
      </div>
      <div class="exp-card fade-in">
        <div class="exp-icon"><i class="fas fa-star"></i></div>
        <h3>Reward Every Visit</h3>
        <p>Earn points with every order. Redeem for free dishes, exclusive tastings, or private dining perks.</p>
      </div>
      <div class="exp-card fade-in">
        <div class="exp-icon"><i class="fas fa-shield-alt"></i></div>
        <h3>Safe & Secure Accounts</h3>
        <p>Save your favorites, track orders, manage reservations, and enjoy a personalized dining journey.</p>
      </div>
    </div>
  </section>

  <!-- Customer Reviews -->
  <section class="reviews" id="reviews">
    <div class="section-header fade-in">
      <span class="section-subtitle">Guest Voices</span>
      <h2 class="section-title">What Our Diners Say</h2>
      <p class="section-desc">Real experiences from our valued guests.</p>
    </div>
    <div class="reviews-grid">
      <div class="review-card fade-in">
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <p class="review-text">"Absolutely stunning ambiance and the truffle risotto was divine. The online ordering made pickup seamless. Will definitely be back!"</p>
        <div class="review-author">
          <div class="author-avatar">EL</div>
          <div class="author-info">
            <h4>Elena Lopez</h4>
            <p>Verified Diner</p>
          </div>
        </div>
      </div>
      <div class="review-card fade-in">
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <p class="review-text">"Joined the rewards program last month and already earned a free dessert. The staff remembers my name and usual table. Feels like home."</p>
        <div class="review-author">
          <div class="author-avatar">MK</div>
          <div class="author-info">
            <h4>Michael Kim</h4>
            <p>Loyalty Member</p>
          </div>
        </div>
      </div>
      <div class="review-card fade-in">
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
        <p class="review-text">"Perfect date night spot. The reservation system was easy, the wine pairing was spot on, and the chocolate fondant was unforgettable."</p>
        <div class="review-author">
          <div class="author-avatar">SJ</div>
          <div class="author-info">
            <h4>Sarah & James</h4>
            <p>Weekend Guests</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Location & Hours -->
  <section class="location" id="location">
    <div class="location-grid">
      <div class="map-placeholder fade-in">
        <i class="fas fa-map-marked-alt fa-3x" style="margin-right: 1rem;"></i>
        Interactive Map Loads Here
      </div>
      <div class="info-block fade-in">
        <span class="section-subtitle">Visit Us</span>
        <h3>Find Your Table</h3>
        <div class="info-row"><span class="info-label">Address</span><span class="info-value">124 Culinary Ave, Downtown</span></div>
        <div class="info-row"><span class="info-label">Phone</span><span class="info-value">(555) 123-4567</span></div>
        <div class="info-row"><span class="info-label">Email</span><span class="info-value">hello@lumiere.com</span></div>
        <div class="info-row"><span class="info-label">Mon - Thu</span><span class="info-value">11:00 AM - 9:00 PM</span></div>
        <div class="info-row"><span class="info-label">Fri - Sat</span><span class="info-value">11:00 AM - 11:00 PM</span></div>
        <div class="info-row"><span class="info-label">Sunday</span><span class="info-value">10:00 AM - 8:00 PM</span></div>
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
          <a href="register.html" class="btn btn-primary">Book a Table</a>
          <a href="login.html" class="btn btn-outline">Track My Order</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Auth CTA -->
  <section class="auth-cta">
    <div class="auth-content fade-in">
      <h2>Join Our Dining Family</h2>
      <p>Create a free account to unlock exclusive perks: faster checkout, personalized recommendations, loyalty points, and early access to seasonal menus.</p>
      <div class="auth-buttons-large">
        <a href="register.html" class="btn btn-accent"><i class="fas fa-user-plus"></i> Create Free Account</a>
        <a href="login.html" class="btn btn-outline" style="border-color: #fff; color: #fff;"><i class="fas fa-sign-in-alt"></i> Sign In</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-grid">
      <div class="footer-col">
        <a href="#" class="logo" style="margin-bottom: 1.5rem; display: inline-block;">Lumi<span>ère</span></a>
        <p>Crafting unforgettable dining experiences since 2018. Fresh ingredients, bold flavors, and warm hospitality.</p>
        <div class="socials">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-tiktok"></i></a>
          <a href="#"><i class="fab fa-yelp"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Dining</h4>
        <ul>
          <li><a href="#menu">Full Menu</a></li>
          <li><a href="#">Reservations</a></li>
          <li><a href="#">Order Online</a></li>
          <li><a href="#">Private Events</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <ul>
          <li><a href="login.html">Sign In</a></li>
          <li><a href="register.html">Join Rewards</a></li>
          <li><a href="#">Order History</a></li>
          <li><a href="#">Saved Favorites</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Allergy Info</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Privacy & Terms</a></li>
        </ul>
      </div>
    </div>
    <div class="copyright">
      &copy; <span id="year"></span> Lumière Restaurant. All rights reserved. Designed for guests, crafted with care.
    </div>
  </footer>

  <script>
    // Mobile Menu
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      const icon = menuToggle.querySelector('i');
      icon.classList.toggle('fa-bars');
      icon.classList.toggle('fa-times');
    });
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        menuToggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
      });
    });

    // Carousel
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.indicator');
    let currentSlide = 0;
    const slideInterval = 3000;
    function goToSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
        indicators[i].classList.remove('active');
        if (i === index) { slide.classList.add('active'); indicators[i].classList.add('active'); }
      });
      currentSlide = index;
    }
    let slideTimer = setInterval(() => goToSlide((currentSlide + 1) % slides.length), slideInterval);
    indicators.forEach((ind, i) => {
      ind.addEventListener('click', () => {
        clearInterval(slideTimer);
        goToSlide(i);
        slideTimer = setInterval(() => goToSlide((currentSlide + 1) % slides.length), slideInterval);
      });
    });

    // Scroll Animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: 0.15 });
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Dynamic Year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const nav = document.querySelector('.navbar');
      nav.style.padding = window.scrollY > 50 ? '0.7rem 5%' : '1rem 5%';
      nav.style.boxShadow = window.scrollY > 50 ? '0 4px 20px rgba(0,0,0,0.1)' : 'none';
    });
  </script>
</body>
</html>