{{-- Welcome View --}}
{{-- This view handles the display and user interaction for Welcome. --}}
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
    .btn-disabled { background: #ccc !important; color: #888 !important; cursor: not-allowed; pointer-events: none; box-shadow: none !important; }
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

    .dropdown-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.8rem 1rem;
      border-radius: 12px;
      font-size: 0.9rem;
      color: var(--text);
      transition: var(--transition);
      font-weight: 500;
    }
    .dropdown-item:hover {
      background: rgba(139,28,58,0.05);
      color: var(--primary);
    }
    .dropdown-item i {
      width: 20px;
      text-align: center;
      color: var(--accent);
      font-size: 1rem;
    }
    .dropdown-item.logout-btn:hover {
      background: rgba(255, 68, 68, 0.05);
      color: #ff4444;
    }
    .user-dropdown {
      position: absolute;
      right: 0;
      top: calc(100% + 15px);
      width: 240px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(0,0,0,0.15);
      border: 1px solid rgba(0,0,0,0.05);
      z-index: 1001;
      padding: 0.7rem;
      transform-origin: top right;
    }

    @media (max-width: 768px) {
      .hidden-mobile { display: none; }
      .user-profile-info { border-left: none !important; padding-left: 0 !important; }
      .menu-toggle { display: block; }
      .nav-links { position: fixed; top: 70px; right: -100%; width: 85%; max-width: 350px; height: calc(100vh - 70px); background: var(--white); flex-direction: column; align-items: flex-start; padding: 2.5rem; box-shadow: -5px 0 20px rgba(0,0,0,0.1); transition: var(--transition); }
      .nav-links.active { right: 0; }
      .auth-buttons { flex-direction: column; width: 100%; margin-top: 1.5rem; }
      .btn { width: 100%; }
      .welcome-grid, .location-grid { grid-template-columns: 1fr; }
    }

    /* Custom Reservation Modal Styles */
    .res-modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2500;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .res-modal-backdrop {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .res-modal-content {
      position: relative;
      width: 100%;
      max-width: 600px;
      background: var(--white);
      border-radius: 24px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.25);
      overflow: hidden;
      z-index: 2501;
      display: flex;
      flex-direction: column;
      animation: zoom-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .res-modal-header {
      padding: 1.8rem 2.2rem;
      border-bottom: 1px solid #f0e9e0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #faf8f5;
    }
    .res-modal-header h2 {
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--dark);
      margin: 0;
    }
    .res-modal-header p {
      margin: 0.3rem 0 0;
      font-size: 0.9rem;
    }
    .res-modal-close {
      background: none;
      border: none;
      padding: 0.6rem;
      border-radius: 50%;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .res-modal-close:hover {
      background: #f0eae1;
    }
    .res-modal-close i {
      font-size: 1.2rem;
      color: var(--text-light);
    }
    .res-modal-body {
      padding: 2.2rem;
    }
    .res-form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }
    @media (max-width: 600px) {
      .res-form-grid {
        grid-template-columns: 1fr;
        gap: 1.2rem;
      }
    }
    .res-form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    .res-form-group.full-width {
      grid-column: span 2;
    }
    @media (max-width: 600px) {
      .res-form-group.full-width {
        grid-column: span 1;
      }
    }
    .res-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-bottom: 0.2rem;
    }
    .res-input {
      width: 100%;
      padding: 1rem 1.2rem;
      border: 1.5px solid #eaeaea;
      border-radius: 14px;
      font-size: 0.95rem;
      font-family: inherit;
      transition: var(--transition);
      background: #fdfdfd;
      color: var(--text);
    }
    .res-input:focus {
      outline: none;
      border-color: var(--primary);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(139,28,58,0.06);
    }
    .res-input-readonly {
      background: #f3eee7;
      border-color: #eae3d8;
      color: #6a6255;
      cursor: not-allowed;
    }
    .res-recommendation {
      padding: 1rem 1.2rem;
      background: rgba(139, 28, 58, 0.05);
      border-left: 4px solid var(--primary);
      border-radius: 0 14px 14px 0;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      animation: fade-in 0.3s ease-out;
    }
    .res-recommendation i {
      color: var(--primary);
      margin-right: 0.8rem;
      font-size: 1.1rem;
    }
    .res-recommendation p {
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--primary);
      margin: 0;
      line-height: 1.4;
    }
    .res-btn-submit {
      width: 100%;
      padding: 1.2rem;
      background: var(--primary);
      color: var(--white);
      font-weight: 700;
      border: none;
      border-radius: 14px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 8px 25px rgba(139,28,58,0.25);
    }
    .res-btn-submit:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(139,28,58,0.35);
    }

    /* Custom Toast Notification Styles */
    .res-toast-container {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
      pointer-events: none;
    }
    .res-toast {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1.2rem 2rem;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
      border: 1.5px solid transparent;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      pointer-events: auto;
      animation: res-toast-slide-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      color: var(--white);
    }
    .res-toast-success {
      background: rgba(46, 125, 50, 0.95);
      border-color: #4caf50;
    }
    .res-toast-error {
      background: rgba(211, 47, 47, 0.95);
      border-color: #f44336;
    }
    .res-toast-info {
      background: rgba(139, 28, 58, 0.95);
      border-color: var(--accent);
    }
    .res-toast-icon {
      font-size: 1.4rem;
      font-weight: 700;
    }
    .res-toast-message {
      font-size: 1rem;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    @keyframes res-toast-slide-in {
      from { transform: translateY(2rem) scale(0.9); opacity: 0; }
      to { transform: translateY(0) scale(1); opacity: 1; }
    }
  </style>
</head>
<body x-data="{
    isUserMenuOpen: false,
    /* ─── Reservation modal state ─────────────────────────────── */
    isReservationModalOpen: false,
    selectedTable: null,
    guestCount: 1,
    availableTables: {{ json_encode($availableTables) }},
    isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
    userData: {{ auth()->check() ? json_encode(['name' => auth()->user()->name, 'email' => auth()->user()->email, 'phone' => auth()->user()->phone]) : 'null' }},

    /* ─── Toast notification state ────────────────────────────── */
    toasts: [],

    /* ─── Computed: tables that match selected category ────────── */
    get filteredTables() {
        if (!this.selectedTable) return [];
        return this.availableTables.filter(t => t.category === this.selectedTable.category);
    },

    /* ─── Computed: capacity recommendation message ────────────── */
    get recommendation() {
        if (!this.selectedTable) return '';
        if (this.guestCount > this.selectedTable.seats) {
            return 'Table ' + this.selectedTable.title + ' has only ' + this.selectedTable.seats + ' seats. We recommend a larger table for ' + this.guestCount + ' guests.';
        }
        return 'Perfect fit! Table ' + this.selectedTable.title + ' (' + this.selectedTable.category + ') has ' + this.selectedTable.seats + ' seats, ideal for ' + this.guestCount + ' guests.';
    },

    /* ─── Open reservation modal, enforce auth ──────────────────── */
    openReservation(category, tableId = null) {
        console.log('Opening reservation for:', category, tableId);
        if (!this.isLoggedIn) {
            console.log('User not logged in, showing toast');
            this.showToast('Please log in or register to book a table.', 'info');
            setTimeout(() => { window.location.href = '{{ route('register') }}'; }, 1800);
            return;
        }

        // Find the table by string ID or category
        const table = this.availableTables.find(t => {
            if (tableId) {
                // Handle various ID formats (string or ObjectId)
                return t.id === tableId || t._id === tableId || (t._id && t._id.$oid === tableId);
            }
            return t.category === category;
        });

        if (!table) {
            console.error('No table found for:', category);
            this.showToast('No available tables found for this category.', 'error');
            return;
        }

        console.log('Table found:', table);
        this.selectedTable = table;
        this.isReservationModalOpen = true;
        
        // Refresh icons in case they are used in modal
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    },

    /* ─── Guard form submission ─────────────────────────────────── */
    handleSubmit(e) {
        if (!this.isLoggedIn) {
            e.preventDefault();
            window.location.href = '{{ route('register') }}';
        }
    },

    /* ─── Show a toast message for 4.5 seconds ──────────────────── */
    showToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4500);
    },

    /* ─── Propose the absolute best-fit table automatically ─────── */
    proposeBestTable() {
        if (this.availableTables.length === 0) return;
        
        // Filter tables that can accommodate the current guest count
        const fittingTables = this.availableTables.filter(t => t.seats >= this.guestCount);
        
        if (fittingTables.length > 0) {
            // Sort by seats ascending to get the most optimized size
            fittingTables.sort((a, b) => a.seats - b.seats);
            const bestFit = fittingTables[0];
            
            // Propose it if current table is too small or way too oversized compared to the best fit
            if (!this.selectedTable || this.selectedTable.seats < this.guestCount || this.selectedTable.seats > bestFit.seats) {
                const currentId = this.selectedTable ? (this.selectedTable.id || this.selectedTable._id) : null;
                const bestFitId = bestFit.id || bestFit._id;
                
                if (currentId !== bestFitId) {
                    this.selectedTable = bestFit;
                    this.showToast('We proposed Table ' + bestFit.title + ' (' + bestFit.category + ') as it best fits ' + this.guestCount + ' guests.', 'info');
                }
            }
        }
    },

    /* ─── On page load: surface any Laravel session flashes ─────── */
    init() {
        // Watch for changes in guest count to dynamically recommend & propose the best suited table
        this.$watch('guestCount', (value) => {
            if (value < 1) this.guestCount = 1;
            this.proposeBestTable();
        });
        @if(session('success')) this.showToast(@js(session('success')), 'success'); @endif
        @if(session('error'))   this.showToast(@js(session('error')),   'error');   @endif
        @if(session('info'))    this.showToast(@js(session('info')),    'info');     @endif
    }
}">

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
        @guest
          <a href="{{ url('/login') }}" class="btn btn-outline">Sign In</a>
          <a href="{{ url('/register') }}" class="btn btn-primary">Create Account</a>
        @endguest

        @auth
          <div class="flex items-center gap-4" style="display: flex; align-items: center; gap: 1.2rem; position: relative;">
              <!-- Hamburger Menu Icon -->
              <button @click="isUserMenuOpen = !isUserMenuOpen" class="profile-hamburger" style="background: none; border: none; cursor: pointer; color: var(--text); font-size: 1.3rem; padding: 0.5rem; transition: var(--transition); display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-bars"></i>
              </button>

              <!-- Profile Section -->
              <div class="user-profile-info" style="display: flex; align-items: center; gap: 0.8rem; border-left: 1px solid rgba(0,0,0,0.1); padding-left: 1rem;">
                  <div class="user-avatar" style="width: 42px; height: 42px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; overflow: hidden; font-size: 0.95rem; border: 2px solid var(--accent-light); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                      @if(Auth::user()->profile_picture)
                          <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                      @else
                          @php
                              $names = explode(' ', Auth::user()->name);
                              $initials = strtoupper(substr($names[0], 0, 1));
                              if (count($names) > 1) {
                                  $initials .= strtoupper(substr($names[count($names)-1], 0, 1));
                              }
                          @endphp
                          {{ $initials }}
                      @endif
                  </div>
                  <div class="user-details hidden-mobile" style="text-align: left;">
                      <p style="font-weight: 700; font-size: 0.9rem; color: var(--text); line-height: 1.2; margin: 0;">{{ Auth::user()->name }}</p>
                      <p style="font-size: 0.75rem; color: var(--text-light); font-weight: 500; margin: 0;">{{ ucfirst(Auth::user()->role) }}</p>
                  </div>
              </div>

              <!-- User Dropdown Menu -->
              <div x-show="isUserMenuOpen" 
                   @click.away="isUserMenuOpen = false"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                   x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                   class="user-dropdown"
                   x-cloak
                   style="display: none;">
                  
                  <div style="padding: 0.8rem 1rem; border-bottom: 1px solid rgba(0,0,0,0.05); margin-bottom: 0.5rem;" class="md:hidden">
                      <p style="font-weight: 700; font-size: 0.95rem; color: var(--text); margin: 0;">{{ Auth::user()->name }}</p>
                      <p style="font-size: 0.75rem; color: var(--text-light); margin: 0;">{{ ucfirst(Auth::user()->role) }}</p>
                  </div>

                  <a href="{{ url('/dashboard/profile') }}" class="dropdown-item">
                      <i class="fas fa-user-circle"></i> <span>Profile</span>
                  </a>
                  <a href="{{ url('/dashboard/notifications') }}" class="dropdown-item">
                      <i class="fas fa-bell"></i> <span>Notifications</span>
                  </a>
                  <a href="{{ url('/dashboard/my-orders') }}" class="dropdown-item">
                      <i class="fas fa-shopping-bag"></i> <span>My Orders</span>
                  </a>
                  <div style="height: 1px; background: rgba(0,0,0,0.05); margin: 0.5rem 0;"></div>
                  <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                      @csrf
                      <button type="submit" class="dropdown-item logout-btn" style="width: 100%; border: none; background: none; text-align: left; color: #ff4444; cursor: pointer; padding: 0.8rem 1rem;">
                          <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                      </button>
                  </form>
              </div>
          </div>
        @endauth
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
      <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070" alt="Interior" class="welcome-img fade-in">
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
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div class="table-price">25,000 XAF</div>
            <span class="text-xs font-bold {{ $standardCount > 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $standardCount }} Available
            </span>
          </div>
          <button @click="openReservation('Standard')" class="btn btn-primary {{ $standardCount > 0 ? '' : 'btn-disabled' }}" style="margin-top: 1.5rem; width: 100%;">Réserver</button>
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
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div class="table-price">35,000 XAF</div>
            <span class="text-xs font-bold {{ $mediumCount > 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $mediumCount }} Available
            </span>
          </div>
          <button @click="openReservation('Medium')" class="btn btn-primary {{ $mediumCount > 0 ? '' : 'btn-disabled' }}" style="margin-top: 1.5rem; width: 100%;">Réserver</button>
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
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div class="table-price">50,000 XAF</div>
            <span class="text-xs font-bold {{ $firstClassCount > 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $firstClassCount }} Available
            </span>
          </div>
          <button @click="openReservation('First Class')" class="btn btn-primary {{ $firstClassCount > 0 ? '' : 'btn-disabled' }}" style="margin-top: 1.5rem; width: 100%;">Réserver</button>
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
      @forelse($meals->take(2)->concat($drinks->take(1)) as $idx => $item)
        <div class="menu-item-card">
          <div class="menu-item-header">
            <h4>{{ $item->name }}</h4>
            <span class="menu-item-price">{{ number_format($item->price) }} FCFA</span>
          </div>
          <p class="menu-item-desc">{{ $item->description }}</p>
          <div class="menu-item-actions">
            <input type="number" min="1" value="1" class="qty-input" id="qty-apercu-{{ $idx }}">
            <button class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 10px;" onclick="addToCart('{{ $item->name }}', {{ $item->price }}, 'apercu', {{ $idx }})">Ajouter</button>
          </div>
        </div>
      @empty
        <p class="text-center w-full col-span-full py-12 text-gray-500">Our chef is preparing something special. Check back soon!</p>
      @endforelse
    </div>

    <div style="text-align: center; margin-top: 4rem;">
      <a href="javascript:void(0)" onclick="openMenu()" class="btn btn-outline" style="padding: 1.2rem 3rem; font-size: 1.1rem;">View Full Menu</a>
    </div>
  </section>

  <!-- 
      Gallery Section 
      Dynamically retrieves and renders guest-uploaded or manager-curated hospitality images from the database.
      Falls back to high-resolution premium Unsplash images if no records exist in the database.
  -->
  <section id="gallery">
    <div class="section-header fade-in">
      <span class="section-subtitle">Gallery</span>
      <h2 class="section-title">A Glimpse of Millenium</h2>
    </div>
    <div class="gallery-grid fade-in">
      {{-- 
          Loop through gallery records fetched dynamically from the database.
          Each record points to a file uploaded through the admin gallery dashboard.
      --}}
      @forelse($gallery as $img)
        <div class="gallery-item">
            <!-- Render the dynamic image using Laravel's public asset storage disk -->
            <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title }}">
            <div class="gallery-overlay">
                <div class="text-center">
                    <p class="text-white font-bold text-sm">{{ $img->title }}</p>
                    <span style="font-size: 0.7rem; display: block; opacity: 0.8; font-weight: 500; text-transform: uppercase; margin-bottom: 0.5rem; color: #ffd700;">{{ $img->category }}</span>
                    <i class="fas fa-search-plus mt-2"></i>
                </div>
            </div>
        </div>
      @empty
        {{-- 
            Fallback State: If the restaurant managers haven't uploaded custom pictures yet,
            we show stunning high-resolution showcase images to keep the aesthetics beautiful.
        --}}
        <div class="gallery-item"><img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
        <div class="gallery-item"><img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
        <div class="gallery-item"><img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
        <div class="gallery-item"><img src="https://images.unsplash.com/photo-1550966871-3ed3c47e2ce2?q=80&w=800"><div class="gallery-overlay"><i class="fas fa-search-plus"></i></div></div>
      @endforelse
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

          <!-- Service Mode Selection -->
          <div style="max-width: 600px; margin: 2rem auto 0; background: white; padding: 1.5rem; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);" x-data="{ serviceType: 'served' }">
              <h4 style="margin-bottom: 1.5rem; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                  <i class="fas fa-concierge-bell"></i> Mode de Service
              </h4>
              <div class="flex gap-4 mb-6">
                  <label class="flex-1 cursor-pointer group">
                      <input type="radio" name="service_type_choice" value="served" x-model="serviceType" class="hidden">
                      <div class="p-5 text-center border-2 rounded-3xl transition-all" :class="serviceType === 'served' ? 'border-[#8B1C3A] bg-[#8B1C3A]/5 text-[#8B1C3A] shadow-inner' : 'border-gray-50 text-gray-400 bg-gray-50/30'">
                          <i class="fas fa-utensils mb-2 block text-2xl"></i>
                          <span class="text-[10px] font-bold uppercase tracking-widest">À Table</span>
                      </div>
                  </label>
                  <label class="flex-1 cursor-pointer group">
                      <input type="radio" name="service_type_choice" value="delivered" x-model="serviceType" class="hidden">
                      <div class="p-5 text-center border-2 rounded-3xl transition-all" :class="serviceType === 'delivered' ? 'border-[#8B1C3A] bg-[#8B1C3A]/5 text-[#8B1C3A] shadow-inner' : 'border-gray-50 text-gray-400 bg-gray-50/30'">
                          <i class="fas fa-truck mb-2 block text-2xl"></i>
                          <span class="text-[10px] font-bold uppercase tracking-widest">Livraison</span>
                      </div>
                  </label>
              </div>

              <!-- Table Selection (for Served) -->
              <div x-show="serviceType === 'served'" x-transition class="space-y-3">
                  <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block px-2">Sélectionnez votre table</label>
                  <div class="relative">
                      <select id="orderTableId" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold text-gray-700 appearance-none focus:ring-2 focus:ring-[#8B1C3A]/10 transition-all">
                          <option value="">-- Choisissez une table --</option>
                          @foreach($availableTables as $t)
                              <option value="{{ $t['id'] }}">Table {{ $t['title'] }} ({{ $t['category'] }})</option>
                          @endforeach
                      </select>
                      <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                  </div>
              </div>

              <!-- Delivery Info (for Delivered) -->
              <div x-show="serviceType === 'delivered'" x-transition class="space-y-4">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                          <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1 px-2">Ville / Quartier</label>
                          <input type="text" id="orderLocation" placeholder="Ex: Bastos, Yaoundé" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold text-gray-700 focus:ring-2 focus:ring-[#8B1C3A]/10 transition-all">
                      </div>
                      <div>
                          <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1 px-2">Adresse Précise</label>
                          <input type="text" id="orderAddress" placeholder="Ex: Face Boulangerie Acropole" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold text-gray-700 focus:ring-2 focus:ring-[#8B1C3A]/10 transition-all">
                      </div>
                  </div>
              </div>
              
              <input type="hidden" id="finalServiceType" :value="serviceType">
          </div>

          <!-- Special Instructions Card -->
          <div style="max-width: 600px; margin: 2rem auto 0; background: white; padding: 1.5rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05);">
              <h4 style="margin-bottom: 1rem; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                  <i class="fas fa-sticky-note"></i> Instructions Spéciales
              </h4>
              <textarea id="orderNotes" placeholder="Ex: J'ai des allergies à l'arachide, cuisson à point, couvert supplémentaire..." 
                        style="width: 100%; border: 1px dashed #ccc; border-radius: 15px; padding: 1.2rem; font-family: inherit; font-size: 0.95rem; resize: none; min-height: 100px; outline: none; transition: var(--transition); background: #fdfdfd;"></textarea>
          </div>

          <div class="mt-8" x-data="{ isSubmitting: false }" style="max-width: 600px; margin: 2.5rem auto 0;">
              <button @click="isSubmitting = true; checkout()" 
                      :disabled="isSubmitting"
                      style="width: 100%; padding: 1.4rem; background: var(--primary); color: white; font-weight: 800; border-radius: 20px; border: none; cursor: pointer; font-size: 20px; transition: var(--transition); box-shadow: 0 12px 25px rgba(139,28,58,0.3); display: flex; align-items: center; justify-content: center; gap: 12px;"
                      class="hover:bg-[#a01c3a] disabled:opacity-50">
                  <i class="fas fa-check-circle" x-show="!isSubmitting"></i>
                  <span x-show="!isSubmitting">Finalize & Submit Order</span>
                  <span x-show="isSubmitting"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
              </button>
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
    // Real data from MongoDB passed via Laravel
    const plats = @json($meals);
    const boissons = @json($drinks);

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
      // Map MongoDB field 'description' to 'desc' for compatibility with existing JS
      const desc = item.description || 'No description available';
      return `
        <div class="menu-item-card">
          <div class="menu-item-header">
            <h4>${item.name}</h4>
            <span class="menu-item-price">${item.price.toLocaleString()} FCFA</span>
          </div>
          <p class="menu-item-desc">${desc}</p>
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

    async function checkout() {
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        try {
            const response = await fetch('{{ route('public.order') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    items: cart,
                    total_price: cart.reduce((acc, item) => acc + (item.price * item.qty), 0),
                    notes: document.getElementById('orderNotes').value,
                    service_type: document.getElementById('finalServiceType').value,
                    table_id: document.getElementById('orderTableId').value,
                    location: document.getElementById('orderLocation').value,
                    address: document.getElementById('orderAddress').value
                })
            });

            const data = await response.json();
            if (data.success) {
                cart = [];
                updateCart();
                closeMenu();
                location.reload(); // To show success if needed or clear state
            } else {
                alert('Something went wrong. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error submitting order. Please check your connection.');
        }
    }

    document.getElementById('year').innerText = new Date().getFullYear();
  </script>
    <!-- Public Reservation Modal -->
    <div x-show="isReservationModalOpen" class="res-modal-overlay" x-cloak>
        <div @click="isReservationModalOpen = false" class="res-modal-backdrop"></div>
        <div class="res-modal-content">
            <div class="res-modal-header">
                <div>
                    <h2>Book Your Table</h2>
                    <p class="text-sm font-bold mt-1" style="color: var(--primary);" x-show="selectedTable" x-text="'Table: ' + selectedTable.title + ' (' + selectedTable.category + ' Class)'"></p>
                </div>
                <button @click="isReservationModalOpen = false" class="res-modal-close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('public.reserve') }}" method="POST" @submit="handleSubmit($event)" class="res-modal-body">
                @csrf
                <!-- Hidden inputs for pre-filled data -->
                <input type="hidden" name="table_id" :value="selectedTable ? (selectedTable.id || selectedTable._id) : ''">

                <div class="res-form-grid">
                    <div class="res-form-group">
                        <label class="res-label">Full Name</label>
                        <input type="text" :value="userData ? userData.name : ''" readonly class="res-input res-input-readonly">
                    </div>
                    <div class="res-form-group">
                        <label class="res-label">Email Address</label>
                        <input type="email" :value="userData ? userData.email : ''" readonly class="res-input res-input-readonly">
                    </div>
                </div>

                <div class="res-form-grid">
                    <div class="res-form-group">
                        <label class="res-label">Phone Number</label>
                        <input type="text" :value="userData ? userData.phone : ''" readonly class="res-input res-input-readonly">
                    </div>
                    <div class="res-form-group">
                        <label class="res-label">Number of Guests</label>
                        <input type="number" name="guest_count" x-model="guestCount" min="1" required class="res-input">
                    </div>
                </div>

                <!-- Recommendation Notification -->
                <template x-if="recommendation">
                    <div class="res-recommendation">
                        <i class="fas fa-lightbulb"></i>
                        <p x-text="recommendation"></p>
                    </div>
                </template>

                <div class="res-form-grid">
                    <div class="res-form-group">
                        <label class="res-label">Date</label>
                        <input type="date" name="reservation_date" required class="res-input">
                    </div>
                    <div class="res-form-group">
                        <label class="res-label">Time</label>
                        <input type="time" name="reservation_time" required class="res-input">
                    </div>
                </div>

                <div class="res-form-group" style="margin-bottom: 1.8rem;">
                    <label class="res-label">Special Requests</label>
                    <textarea name="notes" rows="3" placeholder="Any dietary requirements or special occasions?" class="res-input" style="resize: vertical;"></textarea>
                </div>

                <button type="submit" class="res-btn-submit">
                    Confirm Reservation Request
                </button>
            </form>
        </div>
    </div>

<style>
    [x-cloak] { display: none !important; }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
    @keyframes zoom-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }
    .animate-zoom-in { animation: zoom-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
</style>

<!-- Alpine.js CDN (required for x-data directives) -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Toast Notification Container — state lives on <body> x-data -->
<div class="res-toast-container">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true"
             class="res-toast"
             :class="{
                 'res-toast-success': toast.type === 'success',
                 'res-toast-error':   toast.type === 'error',
                 'res-toast-info':    toast.type === 'info'
             }">
            <span class="res-toast-icon" x-text="toast.type === 'success' ? '✓' : (toast.type === 'error' ? '✕' : 'ℹ')"></span>
            <p class="res-toast-message" x-text="toast.message"></p>
        </div>
    </template>
</div>

</body>
</html>