<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Millenium | Luxury Hospitality</title>
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
    .btn { padding: 0.8rem 1.8rem; border-radius: 50px; font-weight: 600; cursor: pointer; transition: var(--transition); border: 2px solid transparent; font-size: 0.95rem; display: inline-block; text-align: center; }
    .btn-outline { border-color: var(--primary); color: var(--primary); background: transparent; }
    .btn-outline:hover { background: var(--primary); color: white; transform: translateY(-2px); }
    .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(139,28,58,0.3); border: none; }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(139,28,58,0.4); }
    .btn-accent { background: var(--accent); color: var(--dark); border: none; }
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

    /* Reserve Table Section */
    .tables-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .table-card { background: var(--white); border-radius: 20px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); border: 1px solid rgba(0,0,0,0.05); }
    .table-card:hover { transform: translateY(-10px); }
    .table-img-wrapper { position: relative; height: 220px; }
    .table-img { width: 100%; height: 100%; object-fit: cover; }
    .table-badge { position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.9); padding: 0.4rem 0.8rem; border-radius: 10px; font-size: 0.8rem; font-weight: 700; color: var(--primary); }
    .table-content { padding: 1.5rem; }
    .table-info { display: flex; gap: 1.2rem; color: var(--text-light); font-size: 0.9rem; margin-bottom: 1rem; }
    .table-info i { color: var(--accent); }
    .table-price { font-size: 1.4rem; font-weight: 700; color: var(--primary); margin-top: 1rem; }

    /* Services Section */
    .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .service-card { background: var(--white); padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow); text-align: center; transition: var(--transition); }
    .service-card:hover { transform: translateY(-10px); background: var(--primary); color: white; }
    .service-card i { font-size: 3rem; color: var(--accent); margin-bottom: 1.5rem; }
    .service-card:hover i { color: var(--white); }
    .service-card h3 { margin-bottom: 1rem; }

    /* Gallery Section */
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; max-width: 1300px; margin: 0 auto; }
    .gallery-item { position: relative; height: 250px; border-radius: 15px; overflow: hidden; cursor: pointer; }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: var(--transition); }
    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(139,28,58,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: var(--transition); color: white; font-size: 1.5rem; }
    .gallery-item:hover .gallery-overlay { opacity: 1; }

    /* Full Menu Modal */
    .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 2000; display: none; align-items: center; justify-content: center; padding: 2rem; }
    .modal-content { background: var(--bg); width: 100%; max-width: 1100px; height: 90vh; border-radius: 30px; overflow: hidden; display: flex; flex-direction: column; position: relative; }
    .modal-header { padding: 2rem; background: var(--white); border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .modal-close { font-size: 2rem; cursor: pointer; color: var(--text-light); }
    .modal-body { flex-grow: 1; overflow-y: auto; padding: 2rem; }
    
    .menu-tabs { display: flex; gap: 2rem; margin-bottom: 2rem; justify-content: center; }
    .menu-tab { padding: 0.8rem 2rem; border-radius: 50px; background: #eee; cursor: pointer; font-weight: 600; transition: var(--transition); }
    .menu-tab.active { background: var(--primary); color: white; }
    
    .menu-items-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
    .menu-item-card { background: var(--white); padding: 1.5rem; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .menu-item-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
    .menu-item-price { font-weight: 700; color: var(--primary); }
    .menu-item-desc { font-size: 0.85rem; color: var(--text-light); margin-bottom: 1.5rem; height: 40px; overflow: hidden; }
    .menu-item-actions { display: flex; align-items: center; gap: 1rem; }
    .qty-input { width: 60px; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px; text-align: center; }
    
    .cart-summary { background: var(--primary); color: white; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; }

    /* Existing Sections */
    .welcome { background: var(--white); }
    .welcome-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; max-width: 1200px; margin: 0 auto; }
    .welcome-img { width: 100%; height: 450px; object-fit: cover; border-radius: 20px; box-shadow: var(--shadow); }
    .welcome-text h3 { font-size: 2.2rem; margin-bottom: 1rem; color: var(--primary); }
    .welcome-text p { margin-bottom: 1.5rem; font-size: 1.05rem; line-height: 1.8; }
    .features-list { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; }
    .feature-item { display: flex; align-items: center; gap: 0.8rem; font-weight: 500; }
    .feature-item i { color: var(--accent); font-size: 1.2rem; }

    .reviews { background: var(--white); }
    .reviews-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; }
    .review-card { background: var(--bg); padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow); position: relative; transition: var(--transition); }
    .review-card::before { content: '\201C'; position: absolute; top: 15px; left: 25px; font-size: 5rem; color: var(--accent); opacity: 0.2; font-family: 'Playfair Display', serif; line-height: 1; }
    .stars { color: var(--accent); margin-bottom: 1rem; font-size: 1.1rem; }
    .review-text { font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem; position: relative; z-index: 1; }
    .review-author { display: flex; align-items: center; gap: 1rem; }
    .author-avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--white); font-weight: 700; }

    .location { background: var(--bg); }
    .location-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; max-width: 1200px; margin: 0 auto; }
    .map-frame { width: 100%; height: 400px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow); }
    .info-block { background: var(--white); padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow); }
    .info-block h3 { font-size: 1.8rem; margin-bottom: 1.5rem; color: var(--primary); }
    .info-row { display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px dashed #ddd; }

    footer { background: var(--dark); color: #aaa; padding: 4rem 5% 2rem; }
    .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; max-width: 1200px; margin: 0 auto 3rem; }
    .footer-col h4 { color: var(--white); margin-bottom: 1.5rem; font-size: 1.2rem; position: relative; padding-bottom: 0.8rem; }
    .footer-col h4::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: var(--accent); }
    .footer-col ul li { margin-bottom: 0.8rem; }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 768px) {
      .menu-toggle { display: block; }
      .nav-links { position: fixed; top: 70px; right: -100%; width: 85%; max-width: 350px; height: calc(100vh - 70px); background: var(--white); flex-direction: column; align-items: flex-start; padding: 2.5rem; box-shadow: -5px 0 20px rgba(0,0,0,0.1); transition: var(--transition); }
      .nav-links.active { right: 0; }
      .auth-buttons { flex-direction: column; width: 100%; margin-top: 1.5rem; }
      .btn { width: 100%; }
      .welcome-grid, .location-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <a href="#" class="logo">Mille<span>nium</span></a>
    <div class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></div>
    <div class="nav-links" id="navLinks">
      <a href="#about">About</a>
      <a href="#reserve">Reserve</a>
      <a href="#services">Services</a>
      <a href="#gallery">Gallery</a>
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
      <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070')"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1550966871-3ed3c47e2ce2?q=80&w=2070')"></div>
    </div>
    <div class="hero-content">
      <div class="hero-badge">Excellence in Yaoundé</div>
      <h1>Taste the Art of <span style="color: var(--accent); display: block;">Modern Dining</span></h1>
      <p>Luxury stay, exquisite plates, and unforgettable moments. Join us at Millenium for a unique experience.</p>
      <div class="hero-buttons">
        <a href="#reserve" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Reserve a Table</a>
        <a href="javascript:void(0)" onclick="openMenu()" class="btn btn-outline" style="border-color: #fff; color: #fff;"><i class="fas fa-book-open"></i> View Full Menu</a>
      </div>
    </div>
    <div class="carousel-indicators">
      <div class="indicator active" data-slide="0"></div>
      <div class="indicator" data-slide="1"></div>
      <div class="indicator" data-slide="2"></div>
      <div class="indicator" data-slide="3"></div>
      <div class="indicator" data-slide="4"></div>
      <div class="indicator" data-slide="5"></div>
    </div>
  </header>

  <!-- Welcome Section -->
  <section class="welcome" id="about">
    <div class="welcome-grid">
      <img src="https://images.unsplash.com/photo-1552566626-52f8b828b5ad?q=80&w=2070" alt="Interior" class="welcome-img fade-in">
      <div class="welcome-text fade-in">
        <span class="section-subtitle">Our Legacy</span>
        <h3>Where Every Meal is a Masterpiece</h3>
        <p>At Millenium, we redefine luxury. Our restaurant combines the finest local flavors with international flair, served in an atmosphere of unmatched elegance.</p>
        <div class="features-list">
          <div class="feature-item"><i class="fas fa-utensils"></i> Fine Dining</div>
          <div class="feature-item"><i class="fas fa-bed"></i> Luxury Rooms</div>
          <div class="feature-item"><i class="fas fa-wifi"></i> Free High-Speed WiFi</div>
          <div class="feature-item"><i class="fas fa-parking"></i> Secure Parking</div>
        </div>
        <a href="#reserve" class="btn btn-outline">Book Your Experience</a>
      </div>
    </div>
  </section>

  <!-- Reserve Table Section -->
  <section id="reserve">
    <div class="section-header fade-in">
      <span class="section-subtitle">Reserve a Table</span>
      <h2 class="section-title">Choose Your Setting</h2>
      <p class="section-desc">From intimate dinners to group celebrations, find the perfect table for your occasion.</p>
    </div>
    <div class="tables-grid">
      <div class="table-card fade-in">
        <div class="table-img-wrapper">
          <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1000" alt="Standard Table" class="table-img">
          <div class="table-badge">Standard</div>
        </div>
        <div class="table-content">
          <div class="table-info">
            <span><i class="fas fa-users"></i> 2 Places</span>
            <span><i class="fas fa-expand"></i> 15 m²</span>
          </div>
          <h3>Cozy Dining</h3>
          <p>Perfect for a quiet dinner for two.</p>
          <div class="table-price">25,000 XAF</div>
          <a href="#" class="btn btn-primary" style="margin-top: 1.5rem; width: 100%;">Réserver</a>
        </div>
      </div>
      <div class="table-card fade-in">
        <div class="table-img-wrapper">
          <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1000" alt="Medium Class" class="table-img">
          <div class="table-badge">Medium Class</div>
        </div>
        <div class="table-content">
          <div class="table-info">
            <span><i class="fas fa-users"></i> 4 Places</span>
            <span><i class="fas fa-expand"></i> 25 m²</span>
          </div>
          <h3>Family Style</h3>
          <p>Spacious seating for groups and families.</p>
          <div class="table-price">35,000 XAF</div>
          <a href="#" class="btn btn-primary" style="margin-top: 1.5rem; width: 100%;">Réserver</a>
        </div>
      </div>
      <div class="table-card fade-in">
        <div class="table-img-wrapper">
          <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1000" alt="First Class" class="table-img">
          <div class="table-badge">First Class</div>
        </div>
        <div class="table-content">
          <div class="table-info">
            <span><i class="fas fa-users"></i> 6 Places</span>
            <span><i class="fas fa-expand"></i> 40 m²</span>
          </div>
          <h3>VIP Experience</h3>
          <p>Exclusive dining with panoramic views.</p>
          <div class="table-price">50,000 XAF</div>
          <a href="#" class="btn btn-primary" style="margin-top: 1.5rem; width: 100%;">Réserver</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" style="background: var(--white);">
    <div class="section-header fade-in">
      <span class="section-subtitle">Our Services</span>
      <h2 class="section-title">Gourmet Selection</h2>
      <p class="section-desc">Discover our range of culinary delights and refreshing beverages.</p>
    </div>
    <div class="services-grid">
      <div class="service-card fade-in">
        <i class="fas fa-utensils"></i>
        <h3>Authentic Plates</h3>
        <p>From local Cameroonian delicacies to international gourmet dishes.</p>
      </div>
      <div class="service-card fade-in">
        <i class="fas fa-glass-martini-alt"></i>
        <h3>Premium Drinks</h3>
        <p>A curated selection of wines, cocktails, and fresh beverages.</p>
      </div>
    </div>

    <!-- Aperçu du Menu -->
    <div class="section-header fade-in" style="margin-top: 5rem; margin-bottom: 3rem;">
      <span class="section-subtitle">Aperçu du Menu</span>
      <h3>Chef's Selection</h3>
    </div>
    <div class="menu-items-grid fade-in" style="max-width: 1200px; margin: 0 auto;">
      <div class="menu-item-card">
        <div class="menu-item-header">
          <h4>Spaghetti bolognaise</h4>
          <span class="menu-item-price">5,000 FCFA</span>
        </div>
        <p class="menu-item-desc">Sauce tomate, viande hachée, parmesan</p>
        <div class="menu-item-actions">
          <input type="number" min="1" value="1" class="qty-input" id="qty-apercu-0">
          <button class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 10px;" onclick="addToCart('Spaghetti bolognaise', 5000, 'apercu', 0)">Ajouter</button>
        </div>
      </div>
      <div class="menu-item-card">
        <div class="menu-item-header">
          <h4>Poulet DG</h4>
          <span class="menu-item-price">7,000 FCFA</span>
        </div>
        <p class="menu-item-desc">Poulet, plantain, légumes sautés</p>
        <div class="menu-item-actions">
          <input type="number" min="1" value="1" class="qty-input" id="qty-apercu-1">
          <button class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 10px;" onclick="addToCart('Poulet DG', 7000, 'apercu', 1)">Ajouter</button>
        </div>
      </div>
      <div class="menu-item-card">
        <div class="menu-item-header">
          <h4>Guinness Large</h4>
          <span class="menu-item-price">2,000 FCFA</span>
        </div>
        <p class="menu-item-desc">Stout iconique 65cl</p>
        <div class="menu-item-actions">
          <input type="number" min="1" value="1" class="qty-input" id="qty-apercu-2">
          <button class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 10px;" onclick="addToCart('Guinness Large', 2000, 'apercu', 2)">Ajouter</button>
        </div>
      </div>
    </div>

    <div style="text-align: center; margin-top: 4rem;">
      <a href="javascript:void(0)" onclick="openMenu()" class="btn btn-outline" style="padding: 1.2rem 3rem; font-size: 1.1rem;">View Full Menu</a>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery">
    <div class="section-header fade-in">
      <span class="section-subtitle">Gallery</span>
      <h2 class="section-title">A Glimpse of Millenium</h2>
    </div>
    <div class="gallery-grid fade-in">
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1550966871-3ed3c47e2ce2?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1552566626-52f8b828b5ad?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      <div class="gallery-item"><img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
    </div>
  </section>

  <!-- Location Section -->
  <section id="location" class="location">
    <div class="location-grid">
      <div class="map-frame fade-in">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3980.704771694034!2d11.49132177579177!3d3.830491948831093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf4649f8750d%3A0xe549f88417c469b!2sHotel%20la%20Dibamba!5e0!3m2!1sen!2scm!4v1715620000000!5m2!1sen!2scm" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
      <div class="info-block fade-in">
        <span class="section-subtitle">Visit Us</span>
        <h3>Find Your Table</h3>
        <div class="info-row"><span class="info-label">Address</span><span class="info-value">Damas, Yaoundé</span></div>
        <div class="info-row"><span class="info-label">Phone</span><span class="info-value">+237 6XX XX XX XX</span></div>
        <div class="info-row"><span class="info-label">Mon - Sun</span><span class="info-value">11:00 AM - 11:00 PM</span></div>
        <a href="#reserve" class="btn btn-primary" style="margin-top: 2rem; width: 100%;">Book a Table</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-grid">
      <div class="footer-col">
        <a href="#" class="logo" style="margin-bottom: 1.5rem; display: inline-block;">Mille<span>nium</span></a>
        <p>Crafting unforgettable dining experiences since 2018. Fresh ingredients, bold flavors, and warm hospitality.</p>
        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Dining</h4>
        <ul>
          <li><a href="javascript:void(0)" onclick="openMenu()">Full Menu</a></li>
          <li><a href="#reserve">Reservations</a></li>
          <li><a href="#">Order Online</a></li>
          <li><a href="#">Private Events</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <ul>
          <li><a href="{{ url('/login') }}">Sign In</a></li>
          <li><a href="{{ url('/register') }}">Join Rewards</a></li>
          <li><a href="#">Order History</a></li>
          <li><a href="#">Saved Favorites</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Support</h4>
        <ul>
          <li><a href="#location">Contact Us</a></li>
          <li><a href="#">Allergy Info</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Privacy & Terms</a></li>
        </ul>
      </div>
    </div>
    <div style="text-align: center; margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
      &copy; <span id="year"></span> Millenium. All rights reserved.
    </div>
  </footer>

  <!-- Full Menu Modal -->
  <div class="modal" id="menuModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Menu Complet & Commande</h2>
        <span class="modal-close" onclick="closeMenu()">&times;</span>
      </div>
      <div class="modal-body">
        <div class="menu-tabs">
          <div class="menu-tab active" onclick="switchMenuTab('plats')">Plats & Repas</div>
          <div class="menu-tab" onclick="switchMenuTab('boissons')">Boissons</div>
          <div class="menu-tab" onclick="switchMenuTab('panier')" id="basketTab">Mon Panier (<span id="cartCountHeader">0</span>)</div>
        </div>
        
        <div id="platsPane" class="menu-pane">
          <div class="menu-items-grid" id="platsItems">
            <!-- Dynamically loaded -->
          </div>
        </div>
        <div id="boissonsPane" class="menu-pane" style="display:none;">
          <div class="menu-items-grid" id="boissonsItems">
            <!-- Dynamically loaded -->
          </div>
        </div>
        <div id="panierPane" class="menu-pane" style="display:none;">
          <div id="basketList" style="max-width: 600px; margin: 0 auto;">
            <!-- Cart items here -->
          </div>
        </div>
      </div>
      <div class="cart-summary">
        <span>Items: <span id="cartCount">0</span></span>
        <span style="font-size: 1.4rem; font-weight: 700;">Total: <span id="cartTotal">0</span> FCFA</span>
        <button class="btn btn-accent" style="padding: 0.8rem 2rem;" onclick="switchMenuTab('panier')">Voir Panier</button>
      </div>
    </div>
  </div>

  <script>
    // Navigation toggle
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    menuToggle.addEventListener('click', () => navLinks.classList.toggle('active'));

    // Carousel
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.indicator');
    let currentSlide = 0;
    setInterval(() => {
      slides[currentSlide].classList.remove('active');
      indicators[currentSlide].classList.remove('active');
      currentSlide = (currentSlide + 1) % slides.length;
      slides[currentSlide].classList.add('active');
      indicators[currentSlide].classList.add('active');
    }, 4000);

    // Scroll Animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Modal & Cart Logic
    const plats = [
      { name: 'Petit déjeuner simple', desc: '2 oeufs, pain, boisson chaude, beurre', price: 2000 },
      { name: 'Petit déjeuner continental', desc: '2 oeufs, sardine ou saucisse, pain, beurre', price: 3500 },
      { name: 'Petit déjeuner complet', desc: '2 oeufs, sardine, saucisse, pain, beurre', price: 3000 },
      { name: 'Spaghetti bolognaise', desc: 'Sauce tomate, viande hachée, parmesan', price: 5000 },
      { name: 'Poulet DG', desc: 'Poulet, plantain, légumes sautés', price: 7000 }
    ];
    const boissons = [
      { name: 'Isembeck', desc: 'Bière locale blonde', price: 1500 },
      { name: 'Guinness Small', desc: 'Stout iconique 33cl', price: 1500 },
      { name: 'Guinness Large', desc: 'Stout iconique 65cl', price: 2000 },
      { name: 'Coca Cola', desc: 'Rafraîchissement gazeux', price: 1000 },
      { name: 'Eau Minérale', desc: 'Source naturelle 1.5L', price: 800 }
    ];

    let cart = [];

    function openMenu() {
      document.getElementById('menuModal').style.display = 'flex';
      renderMenu();
    }
    function closeMenu() {
      document.getElementById('menuModal').style.display = 'none';
    }

    function switchMenuTab(tab) {
      document.querySelectorAll('.menu-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.menu-pane').forEach(p => p.style.display = 'none');
      
      if (tab === 'plats') {
        document.getElementById('platsPane').style.display = 'block';
        document.querySelector('.menu-tab:nth-child(1)').classList.add('active');
      } else if (tab === 'boissons') {
        document.getElementById('boissonsPane').style.display = 'block';
        document.querySelector('.menu-tab:nth-child(2)').classList.add('active');
      } else {
        document.getElementById('panierPane').style.display = 'block';
        document.getElementById('basketTab').classList.add('active');
        renderBasket();
      }
    }

    function renderMenu() {
      const platsGrid = document.getElementById('platsItems');
      const boissonsGrid = document.getElementById('boissonsItems');
      platsGrid.innerHTML = plats.map((item, idx) => createItemCard(item, 'plats', idx)).join('');
      boissonsGrid.innerHTML = boissons.map((item, idx) => createItemCard(item, 'boissons', idx)).join('');
    }

    function createItemCard(item, type, idx) {
      return `
        <div class="menu-item-card">
          <div class="menu-item-header">
            <h4>${item.name}</h4>
            <span class="menu-item-price">${item.price.toLocaleString()} FCFA</span>
          </div>
          <p class="menu-item-desc">${item.desc}</p>
          <div class="menu-item-actions">
            <input type="number" min="1" value="1" class="qty-input" id="qty-${type}-${idx}">
            <button class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 10px;" onclick="addToCart('${item.name}', ${item.price}, '${type}', ${idx})">Ajouter</button>
          </div>
        </div>
      `;
    }

    function addToCart(name, price, type, idx) {
      const qtyInput = document.getElementById(`qty-${type}-${idx}`);
      const qty = parseInt(qtyInput.value);
      
      const existing = cart.find(i => i.name === name);
      if (existing) {
        existing.qty += qty;
      } else {
        cart.push({ name, price, qty });
      }
      updateCart();
      qtyInput.value = 1; // Reset input
    }

    function removeFromCart(index) {
      cart.splice(index, 1);
      updateCart();
      renderBasket();
    }

    function renderBasket() {
      const basketList = document.getElementById('basketList');
      if (cart.length === 0) {
        basketList.innerHTML = '<p style="text-align:center; padding: 3rem;">Votre panier est vide.</p>';
        return;
      }
      basketList.innerHTML = cart.map((item, index) => `
        <div style="display:flex; justify-content:space-between; align-items:center; background:white; padding:1.5rem; border-radius:15px; margin-bottom:1rem; box-shadow:0 5px 15px rgba(0,0,0,0.05);">
          <div>
            <h4 style="margin:0;">${item.name}</h4>
            <p style="margin:0; color:var(--text-light); font-size:0.9rem;">${item.qty} x ${item.price.toLocaleString()} FCFA</p>
          </div>
          <div style="display:flex; align-items:center; gap:1.5rem;">
            <strong style="color:var(--primary);">${(item.qty * item.price).toLocaleString()} FCFA</strong>
            <i class="fas fa-trash-alt" style="color:#ff4444; cursor:pointer;" onclick="removeFromCart(${index})"></i>
          </div>
        </div>
      `).join('');
    }

    function updateCart() {
      let count = 0;
      let total = 0;
      cart.forEach(item => {
        count += item.qty;
        total += item.qty * item.price;
      });
      document.getElementById('cartCount').innerText = count;
      document.getElementById('cartCountHeader').innerText = count;
      document.getElementById('cartTotal').innerText = total.toLocaleString();
    }

    document.getElementById('year').innerText = new Date().getFullYear();
  </script>
</body>
</html>