<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description"
        content="ZE Vapestore - Premium vape products and accessories. Age restricted - 21+ only." />
    <meta name="keywords" content="vape, vaping, e-cigarette, vape store, vape products" />
    <title>ZE Vapestore - Premium Vape Products</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/whrNy6j6/Pngtree-vape-device-8133386.png" />

    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button {
            cursor: pointer;
            border: none;
            outline: none;
        }


        /* Navigation */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 3rem;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav .logo {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
        }

        nav .logo img {
            height: 40px;
            width: 40px;
            margin-right: 0.5rem;
            border-radius: 50%;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav ul li {
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        nav ul li:hover {
            color: #007bff;
        }

        nav ul li.cart-icon {
            font-size: 1.5rem;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 500px;
        }

        .hero-text {
            flex: 1;
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #333;
            font-weight: 700;
        }

        .hero-text .highlight {
            color: #007bff;
        }

        .hero-text p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #666;
            line-height: 1.6;
        }

        .btn-explore {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-explore:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .btn-explore svg {
            margin-left: 0.5rem;
            width: 18px;
            height: 18px;
            transition: transform 0.3s ease;
        }

        .btn-explore:hover svg {
            transform: translateX(5px);
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 350px;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.2));
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            font-weight: 700;
            font-size: 2rem;
            margin: 4rem 0 2rem 0;
            position: relative;
            color: #333;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(.77,0,.18,1);
        }

        .section-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            margin: 1rem auto 0 auto;
            border-radius: 2px;
        }

        .section-title.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Products Grid */
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(.77,0,.18,1), box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            opacity: 0;
            transform: translateY(40px);
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0);
            animation: fadeInUp 0.8s;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.04);
            box-shadow: 0 18px 40px rgba(0,0,0,0.18);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .product-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product-rating {
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.2rem;
        }

        .product-price {
            font-weight: 700;
            font-size: 1.2rem;
            color: #007bff;
        }

        .add-to-cart {
            background:rgb(52, 54, 77);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin-top: 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart:active {
            transform: scale(0.97);
        }

        /* Star rating */
        .star {
            font-size: 1.2rem;
            color: #ffc107;
        }

        .star.empty {
            color: #ddd;
        }

        .rating-number {
            margin-left: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        /* Brand logos */
        .brands {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            margin: 4rem auto;
            flex-wrap: wrap;
            max-width: 1000px;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .brands img {
            height: 50px;
            object-fit: contain;
            transition: all 0.7s cubic-bezier(.77,0,.18,1);
            filter: grayscale(100%);
            opacity: 0;
            transform: scale(0.7);
        }

        .brands img.visible {
            opacity: 1;
            transform: scale(1);
            animation: bounceIn 0.8s;
        }

        .brands img:hover {
            filter: grayscale(0%);
            transform: scale(1.1);
        }

        /* Loading Animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 3rem 2rem 1rem;
            margin-top: 4rem;
        }

        footer .footer-top {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 2rem;
        }

        footer .footer-logo {
            text-align: center;
        }

        footer .footer-logo img {
            height: 60px;
            margin-bottom: 1rem;
            border-radius: 50%;
        }

        footer .footer-logo p {
            font-size: 0.9rem;
            color: #bdc3c7;
        }

        footer .footer-links h4 {
            margin-bottom: 1rem;
            font-weight: 600;
            color: #fff;
        }

        footer .footer-links ul li {
            margin-bottom: 0.5rem;
            cursor: pointer;
            color: #bdc3c7;
            transition: color 0.3s ease;
        }

        footer .footer-links ul li:hover {
            color: #3498db;
        }

        footer .app-download {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        footer .app-download img {
            height: 50px;
            transition: transform 0.3s ease;
        }

        footer .app-download img:hover {
            transform: scale(1.05);
        }

        footer hr {
            border: none;
            border-top: 1px solid #34495e;
            margin: 2rem 0 1rem;
        }

        footer .copyright {
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        footer {
            padding: 2rem 1rem 1rem;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                padding: 1rem;
                flex-wrap: wrap;
            }

            nav ul {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 1rem;
                margin-top: 1rem;
            }

            nav ul.show {
                display: flex;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1rem;
            }

            .hero-text {
                max-width: 100%;
                margin-bottom: 2rem;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
                margin: 2rem 0 1rem;
            }

            .products-container {
                padding: 0 1rem;
            }

            .brands {
                gap: 1.5rem;
                padding: 1rem;
            }

            .brands img {
                height: 40px;
            }

        }

        /* Accessibility */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus states */
        button:focus,
        a:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }

        .age-modal {
    display: flex;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease-out;
}

.age-modal-content {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    margin: 5% auto;
    padding: 0;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: slideIn 0.4s ease-out;
}

.age-modal-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 2rem 1.5rem 1.5rem;
    border-radius: 20px 20px 0 0;
}

.age-modal-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.age-modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.age-modal-body {
    padding: 2rem 1.5rem;
    color: #333;
}

.age-modal-body p {
    margin: 0.8rem 0;
    line-height: 1.6;
    font-size: 1rem;
}

.age-modal-body p:first-child {
    font-size: 1.1rem;
    color: #555;
}

.age-modal-body strong {
    color: #dc3545;
    font-weight: 700;
}

.age-modal-buttons {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.age-btn {
    flex: 1;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 30px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.age-btn-yes {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.age-btn-yes:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
}

.age-btn-no {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.age-btn-no:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
}

.age-modal-footer {
    background: #f8f9fa;
    padding: 1rem 1.5rem;
    border-radius: 0 0 20px 20px;
    border-top: 1px solid #e9ecef;
}

.age-modal-footer p {
    margin: 0;
    font-size: 0.85rem;
    color: #6c757d;
    font-style: italic;
}

.page-blocked {
    filter: blur(5px);
    pointer-events: none;
    user-select: none;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .age-modal-content {
        width: 95%;
        margin: 10% auto;
    }
    
    .age-modal-buttons {
        flex-direction: column;
    }
    
    .age-btn {
        margin: 0.5rem 0;
    }
    
    .age-modal-header {
        padding: 1.5rem 1rem;
    }
    
    .age-modal-body {
        padding: 1.5rem 1rem;
    }
}
/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Better mobile menu animation */
nav ul {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    nav ul {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 10px 10px;
        transform: translateY(-20px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    nav ul.show {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }
    
    nav ul li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    
    nav ul li:last-child {
        border-bottom: none;
    }
    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.7); }
        60% { opacity: 1; transform: scale(1.1); }
        80% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
    .animate-fadeinup {
        opacity: 0;
        animation: fadeInUp 1s forwards;
    }
    .animate-fadein {
        opacity: 0;
        animation: fadeIn 1s forwards;
    }
    .animate-bouncein {
        opacity: 0;
        animation: bounceIn 1s forwards;
    }
    .product-card {
        /* ...existing... */
        transition: all 0.3s cubic-bezier(.77,0,.18,1), box-shadow 0.3s;
        opacity: 0;
        transform: translateY(40px);
    }
    .product-card.visible {
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.8s;
    }
    .product-card:hover {
        transform: translateY(-10px) scale(1.04);
        box-shadow: 0 18px 40px rgba(0,0,0,0.18);
    }
    .add-to-cart, .btn-explore {
        /* ...existing... */
        position: relative;
        overflow: hidden;
    }
    .add-to-cart:active, .btn-explore:active {
        transform: scale(0.97);
    }
    .brands img {
        opacity: 0;
        transform: scale(0.7);
        transition: all 0.7s cubic-bezier(.77,0,.18,1);
    }
    .brands img.visible {
        opacity: 1;
        transform: scale(1);
        animation: bounceIn 0.8s;
    }
    /* ...existing responsive... */
    </style>
</head>

<body>
    <!-- Age Warning Modal -->
     <div id="ageModal" class="age-modal">
    <div class="age-modal-content">
        <div class="age-modal-header">
            <img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="ZE Vapestore Logo" class="age-modal-logo">
            <h2>Age Verification Required</h2>
        </div>
        <div class="age-modal-body">
            <p>This website contains information about vaping products intended for adults only.</p>
            <p><strong>You must be 21 years or older to enter this site.</strong></p>
            <p>Please verify your age before continuing:</p>
        </div>
        <div class="age-modal-buttons">
            <button id="ageYes" class="age-btn age-btn-yes">I am 21 or older</button>
            <button id="ageNo" class="age-btn age-btn-no">I am under 21</button>
        </div>
        <div class="age-modal-footer">
            <p>By entering this site, you certify that you are of legal smoking age in your jurisdiction.</p>
        </div>
    </div>
</div>

    <nav>
        <div class="logo">
<img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="logo vape" loading="lazy" />

            <span>ZE Vapestore</span>
        </div>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul id="navMenu">
            <li><a href="#home">Home</a></li>
            <li><a href="#products">Products</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#find-us">Find Us</a></li>
            <li><a href="#contact-us">Contact</a></li>
            <!-- Check if user is logged in -->
                <?php if ($is_logged_in): ?>
                <li style="display:flex;align-items:center;gap:0.5rem;">
                  <?php
                    $foto = isset($customer->foto) && $customer->foto ? $customer->foto : null;
                    $nama = isset($customer->nama_lengkap) && $customer->nama_lengkap ? $customer->nama_lengkap : ($username ?? 'User');
                    if ($foto && file_exists(FCPATH . 'assets/uploads/' . $foto)) {
                        $img_src = base_url('assets/uploads/' . $foto);
                    } else {
                        $img_src = 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=6366f1&color=fff&size=36';
                    }
                  ?>
                  Hello, <a href="<?php echo base_url('index.php/Account/account'); ?>"><?= htmlspecialchars($nama); ?></a>!
                  <img src="<?php echo $img_src; ?>" alt="Foto Profil" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #6366f1;cursor:pointer;" onclick="showProfileModal('<?php echo $img_src; ?>')">

                </li>
                
                <li><a href="<?php echo base_url('index.php/Auth/logout'); ?>"onclick="showLogoutModal(); return false;">Logout</a></li>
                <?php else: ?>
                <li><a href="<?php echo base_url('index.php/Auth/signin'); ?>">Login</a></li>
                <li><a href="<?php echo base_url('index.php/Auth/signup'); ?>">Sign Up</a></li>
                <?php endif; ?>
           
    </nav>
    <section class="hero" id="home">
        <div class="hero-text animate-fadeinup">
            <h1>Welcome to<br><span class="highlight">ZE Vapestore</span></h1>
            <p>Premium vaping products and accessories for adult users. Discover our curated collection of high-quality
                devices and e-liquids.</p>
            <a href="#products" class="btn-explore" onclick="scrollToProducts(); return false;">Explore Products</a>
        </div>
        <div class="hero-image animate-fadein">
<img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="logo vape" loading="lazy" />
        </div>
    </section>

     
 <section id="products">
    <h2 class="section-title">Featured Products</h2>
    <div class="products-container">
        <div class="products-grid" id="featuredProducts">
            <?php if (isset($featured_products) && is_array($featured_products) && !empty($featured_products)): ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="product-card">
                        <!-- Use the correct 'gambar' field for the image -->
                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             loading="lazy" />
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="product-rating">
                            <?php 
                            $rating = floatval($product['rating'] ?? 0);
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            
                            for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $fullStars): ?>
                                    <span class="star">★</span>
                                <?php elseif ($i == $fullStars + 1 && $hasHalfStar): ?>
                                    <span class="star">☆</span>
                                <?php else: ?>
                                    <span class="star empty">☆</span>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <span class="rating-number">(<?= number_format($rating, 1) ?>)</span>
                        </div>
                        <div class="product-price"><?= htmlspecialchars($product['price']) ?></div>
                        
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="loading">
                    <div class="spinner"></div>
                </div>
                <p style="text-align: center; grid-column: 1 / -1;">No featured products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <h2 class="section-title">Latest Products</h2>
    <div class="products-container">
        <div class="products-grid" id="latestProducts">
            <?php if (isset($latest_products) && is_array($latest_products) && !empty($latest_products)): ?>
                <?php foreach ($latest_products as $product): ?>
                    <div class="product-card">
                        <!-- Use the correct 'gambar' field for the image -->
                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             loading="lazy" />
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="product-rating">
                            <?php 
                            $rating = floatval($product['rating'] ?? 0);
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            
                            for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $fullStars): ?>
                                    <span class="star">★</span>
                                <?php elseif ($i == $fullStars + 1 && $hasHalfStar): ?>
                                    <span class="star">☆</span>
                                <?php else: ?>
                                    <span class="star empty">☆</span>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <span class="rating-number">(<?= number_format($rating, 1) ?>)</span>
                        </div>
                        
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
              
                <p style="text-align: center; grid-column: 1 / -1;">No latest products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>




    <section id="about" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
        <h2 class="section-title">About Us</h2>
        <p
            style="text-align: center; font-size: 1.1rem; color: #555; max-width: 800px; margin: 1rem auto 0 auto; line-height: 1.6;">
            ZE Vapestore is dedicated to providing premium vaping products and accessories for adult users.
            We prioritize quality, safety, and customer satisfaction, offering a curated selection of devices,
            e-liquids, and accessories.
            Our mission is to enhance your vaping experience with trusted brands and exceptional service.
        </p>
    </section>

    <section id="find-us" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem; text-align: center;">
        <h2 class="section-title">Find Us</h2>
        <iframe src="https://www.google.com/maps?q=ZE+Vapestore&output=embed" width="100%" height="450"
            style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" title="Location Map">
        </iframe>
    </section>

    <section id="contact-us" style="max-width: 1200px; margin: 4rem auto 6rem auto; padding: 0 2rem;">
        <h2 class="section-title" style="text-align: center; margin-bottom: 3rem;">Contact Us</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
            <div style="flex: 1 1 300px; max-width: 400px;">
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="width: 24px; height: 24px; flex-shrink: 0;" viewBox="0 0 24 24" aria-hidden="true"
                        focusable="false">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-4H9v4a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2z">
                        </path>
                    </svg>
                    <div>
                        <strong>Jalan MT. Haryono kp serang No.9,</strong><br />
                        RT.1/RW.3, Taman Rahayu, Kec. Setu, Kabupaten Bekasi, Jawa Barat 17320
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="width: 24px; height: 24px; flex-shrink: 0;" viewBox="0 0 24 24" aria-hidden="true"
                        focusable="false">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                    <div>
                        <strong>+62 8212345678</strong><br />
                        Monday to Saturday, 10 AM to 6PM
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="width: 24px; height: 24px; flex-shrink: 0;" viewBox="0 0 24 24" aria-hidden="true"
                        focusable="false">
                        <path d="M4 4h16v16H4z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <div>
                        <strong>info@ZEvapestore.com</strong><br />
                        Email us your query
                    </div>
                </div>
            </div>
            <div style="flex: 1 1 300px; max-width: 500px; display: flex; flex-direction: column; gap: 1rem;">
                <?php if ($this->session->flashdata('success')): ?>
                    <div id="contactSuccessMsg" style="background:#e6f9ed;color:#15803d;padding:0.9rem 1.2rem;border-radius:8px;font-weight:600;display:flex;align-items:center;gap:0.7rem;box-shadow:0 2px 8px rgba(16,185,129,0.08);transition:opacity 0.5s;">
                        <span style="font-size:1.3rem;">✅</span> <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($customer) && $customer): ?>
                    <div style="background:#e3f2fd;color:#1565c0;padding:0.9rem 1.2rem;border-radius:8px;font-weight:500;display:flex;align-items:center;gap:0.7rem;box-shadow:0 2px 8px rgba(21,101,192,0.08);">
                        <span style="font-size:1.3rem;">ℹ️</span> 
                        Your customer information will be automatically used for this feedback.
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo site_url('index.php/Complaint/submit'); ?>" method="post" aria-label="Contact form" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="text" name="name" placeholder="Enter your name" required
                    style="padding: 0.75rem 1rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"
                    value="<?php echo isset($customer->nama_lengkap) ? htmlspecialchars($customer->nama_lengkap) : ''; ?>"
                    <?php echo isset($customer->nama_lengkap) ? 'readonly' : ''; ?> />
                <input type="email" name="email" placeholder="Enter your email address" required
                    style="padding: 0.75rem 1rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"
                    value="<?php echo isset($customer->email) ? htmlspecialchars($customer->email) : ''; ?>"
                    <?php echo isset($customer->email) ? 'readonly' : ''; ?> />
                <input type="text" name="subject" placeholder="Enter your subject" required
                    style="padding: 0.75rem 1rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;" />
                    
                <textarea name="message" placeholder="Message" required rows="5"
                    style="padding: 0.75rem 1rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem; resize: vertical;"></textarea>
                        <div style="display:flex;align-items:center;gap:0.5rem;margin:0.2rem 0 0.2rem 0;">
                        <label style="font-weight:600;color:#555;min-width:70px;">Rating</label>
                        <div id="contactStarRating" style="font-size:1.5rem;cursor:pointer;user-select:none;">
                            <span class="star" data-value="1">☆</span>
                            <span class="star" data-value="2">☆</span>
                            <span class="star" data-value="3">☆</span>
                            <span class="star" data-value="4">☆</span>
                            <span class="star" data-value="5">☆</span>
                        </div>
                        <input type="hidden" name="rating" id="contactRatingInput" value="0">
                    </div>
                <button type="submit"
                    style="background-color: #ccc; border: none; border-radius: 20px; padding: 0.75rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: background-color 0.3s ease;">Send</button>
            </form>
            </div>
        </div>
    </section>

    <!-- Feedback/Review Section -->
    <section id="feedback-section" style="max-width: 1200px; margin: 0 auto 4rem auto; padding: 0 2rem;">
        <h2 class="section-title" style="margin-bottom: 2rem; text-align:center;">Customer Reviews & Suggestions</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">
            <?php if (isset($complaints) && is_array($complaints) && count($complaints) > 0): ?>
                <?php foreach ($complaints as $c): ?>
                    <div style="
                        background: #fff;
                        border-radius: 16px;
                        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
                        padding: 1.5rem 1.2rem;
                        width: 340px;
                        min-height: 180px;
                        display: flex;
                        flex-direction: column;
                        gap: 0.7rem;
                        animation: fadeIn 0.7s;
                        position: relative;
                    ">
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <div style="
                                width: 44px; height: 44px;
                                background: #e8f0fe;
                                border-radius: 50%;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 1.3rem; font-weight: 700; color: #1a73e8;
                            ">
                                <?php 
                                // Use customer_name if available (from joined data), otherwise use name
                                $displayName = isset($c->customer_name) && !empty($c->customer_name) ? $c->customer_name : $c->name;
                                echo strtoupper(substr($displayName, 0, 1)); 
                                ?>
                            </div>
                            <div>
                                <div style="font-weight:600; color:#222;">
                                    <?php 
                                    // Use customer_name if available, otherwise use name
                                    $displayName = isset($c->customer_name) && !empty($c->customer_name) ? $c->customer_name : $c->name;
                                    echo htmlspecialchars($displayName); 
                                    ?>
                                </div>
                                <div style="color:#888; font-size:0.95rem;"><?php echo date('d M Y', strtotime($c->created_at)); ?></div>
                                <?php if (isset($c->customer_id) && $c->customer_id): ?>
                                    <div style="color:#4CAF50; font-size:0.85rem; font-weight:500;">✓ Verified Customer</div>
                                <?php endif; ?>
                            </div>
                            <?php
                            $is_keluhan = strtolower($c->subject) == 'keluhan' || strtolower($c->subject) == 'complaint';
                            $is_saran = strtolower($c->subject) == 'saran' || strtolower($c->subject) == 'suggestion';
                            if ($is_keluhan) {
                                $badge_bg = '#fff4f4';
                                $badge_color = '#e53935';
                                $badge_icon = '⚠️';
                            } elseif ($is_saran) {
                                $badge_bg = '#e8f5e9';
                                $badge_color = '#43a047';
                                $badge_icon = '💡';
                            } else {
                                $badge_bg = '#e3f2fd';
                                $badge_color = '#1565c0';
                                $badge_icon = '📝';
                            }
                            ?>
                            <span style="
                                margin-left:auto;
                                display: flex;
                                align-items: center;
                                gap: 0.4em;
                                background: <?= $badge_bg ?>;
                                color: <?= $badge_color ?>;
                                padding: 4px 14px;
                                border-radius: 14px;
                                font-size: 1rem;
                                font-weight: 600;
                                box-shadow: 0 2px 8px rgba(<?= $is_keluhan ? '229,57,53,0.07' : ($is_saran ? '67,160,71,0.07' : '21,101,192,0.07') ?>);
                            ">
                                <span style="font-size:1.2em;"><?= $badge_icon ?></span>
                                <?= htmlspecialchars($c->subject) ?>
                            </span>
                        </div>
                        <?php if (!empty($c->rating) && intval($c->rating) > 0): ?>
                        <div style="margin:0.2rem 0 0.5rem 0;">
                            <?php for ($i=1; $i<=5; $i++): ?>
                                <span class="star" style="font-size:1.2rem;color:<?= $i <= $c->rating ? '#ffc107' : '#ddd' ?>;">★</span>
                            <?php endfor; ?>
                            <span style="color:#888;font-size:0.98rem;">(<?= intval($c->rating) ?>)</span>
                        </div>
                        <?php endif; ?>
                        <div style="color:#444; font-size:1.07rem; line-height:1.6; margin-top:0.2rem; white-space:pre-line;">
                            <?php echo nl2br(htmlspecialchars($c->message)); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#888; text-align:center;">No feedback yet. Be the first to leave a review or suggestion!</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="brands" id="brands">
        <?php if (isset($brands) && is_array($brands) && !empty($brands)): ?>
            <?php foreach ($brands as $brand): ?>
                <img src="<?= htmlspecialchars($brand['image']) ?>" alt="<?= htmlspecialchars($brand['alt']) ?> Brand Logo"
                    loading="lazy" onerror="this.style.display='none'" />
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: #666;">Trusted by leading brands worldwide</p>
        <?php endif; ?>
    </section>

    <footer id="contact">
        <div class="footer-top">
            <div class="app-download">
                <h4>Download Our App</h4>
                <a href="#" aria-label="Download on Google Play">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                        alt="Get it on Google Play" loading="lazy" />
                </a>
                <a href="#" aria-label="Download on App Store">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/67/App_Store_(iOS).svg"
                        alt="Download on the App Store" loading="lazy" />
                </a>
            </div>

            <div class="footer-logo">
<img src="<?php echo base_url('assets/gambar/vape.png'); ?>" alt="logo vape" loading="lazy" />
                <h3>ZE Vapestore</h3>
                <p>Premium vaping experience for adults</p>
            </div>

            <div class="footer-links">
                <div>
                    <h4 style="color: white;">Useful Links</h4>
                    <ul>
                        <li><a href="#coupons" style="color: white;">Coupons</a></li>
                        <li><a href="#blog" style="color: white;">Blog Posts</a></li>
                        <li><a href="#return-policy" style="color: white;">Return Policy</a></li>
                        <li><a href="#affiliate" style="color: white;">Join Affiliate</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: white;">Follow Us</h4>
                    <ul>
                        <li><a href="#facebook" style="color: white;">Facebook</a></li>
                        <li><a href="#twitter" style="color: white;">Twitter</a></li>
                        <li><a href="https://www.instagram.com/zee_vapestore/?utm_source=ig_web_button_share_sheet" style="color: white;">Instagram</a></li>
                        <li><a href="#youtube" style="color: white;">Youtube</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <hr />
        <div class="copyright">
            <p>&copy; <?= date('Y') ?> ZE Vapestore. All rights reserved. | Age restricted - 21+ only</p>
        </div>
    </footer>

   <script>
// Age Verification JavaScript - Navigation Fix
let ageVerified = false;
let eventListenersSetup = false;

// Single DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking age verification...');
    
    // Always setup event listeners first
    setupAgeVerificationButtons();
    
    // Check localStorage
    const storedAge = localStorage.getItem('ageVerified');
    console.log('Stored age verification:', storedAge);
    
    if (storedAge === 'true') {
        ageVerified = true;
        console.log('Age already verified, modal will not show');
        // Make sure modal is hidden
        const modal = document.getElementById('ageModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        unblockPage();
        return;
    }
    
    console.log('Age not verified, showing modal');
    ageVerified = false;
    showAgeModal();
    blockPage();
});

function setupAgeVerificationButtons() {
    if (eventListenersSetup) {
        console.log('Event listeners already setup, skipping');
        return;
    }
    
    console.log('Setting up event listeners...');
    
    // Wait a bit for elements to be ready
    setTimeout(() => {
        const ageYesBtn = document.getElementById('ageYes');
        const ageNoBtn = document.getElementById('ageNo');
        const ageModal = document.getElementById('ageModal');
        
        if (ageYesBtn) {
            // Remove existing listeners first
            ageYesBtn.removeEventListener('click', handleYesClick);
            ageYesBtn.addEventListener('click', handleYesClick);
            console.log('Yes button listener added');
        } else {
            console.log('Age Yes button not found');
        }
        
        if (ageNoBtn) {
            // Remove existing listeners first
            ageNoBtn.removeEventListener('click', handleNoClick);
            ageNoBtn.addEventListener('click', handleNoClick);
            console.log('No button listener added');
        } else {
            console.log('Age No button not found');
        }
        
        // Prevent modal from closing by clicking outside
        if (ageModal) {
            ageModal.removeEventListener('click', handleModalClick);
            ageModal.addEventListener('click', handleModalClick);
            console.log('Modal click listener added');
        } else {
            console.log('Age modal not found');
        }
        
        eventListenersSetup = true;
    }, 100);
}

// Separate handler functions to avoid duplicates
function handleYesClick(e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('Yes button clicked');
    
    ageVerified = true;
    localStorage.setItem('ageVerified', 'true');
    console.log('Age verification saved to localStorage');
    
    hideAgeModal();
    showNotification('Welcome to ZE Vapestore!');
}

function handleNoClick(e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('No button clicked');
    
    alert('Sorry, you must be 21 or older to access this website. You will be redirected to a search engine.');
    
    setTimeout(function() {
        window.location.href = 'https://www.google.com';
    }, 2000);
}

function handleModalClick(e) {
    if (e.target === this && !ageVerified) {
        console.log('Modal background clicked, preventing close');
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
}

function showAgeModal() {
    const modal = document.getElementById('ageModal');
    if (modal) {
        console.log('Showing age modal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Re-setup listeners when showing modal
        if (!eventListenersSetup) {
            setupAgeVerificationButtons();
        }
    } else {
        console.log('Modal element not found!');
    }
}

function hideAgeModal() {
    const modal = document.getElementById('ageModal');
    if (modal) {
        console.log('Hiding age modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        unblockPage();
    }
}

function blockPage() {
    const selectors = ['nav', '.hero', '#products', '#about', '#find-us', '#contact-us', 'footer'];
    
    selectors.forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            element.classList.add('page-blocked');
        }
    });
    console.log('Page blocked');
}

function unblockPage() {
    document.querySelectorAll('.page-blocked').forEach(element => {
        element.classList.remove('page-blocked');
    });
    console.log('Page unblocked');
}

// Alternative approach - use event delegation on document
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'ageYes') {
        console.log('Age Yes clicked via delegation');
        handleYesClick(e);
    }
    
    if (e.target && e.target.id === 'ageNo') {
        console.log('Age No clicked via delegation');
        handleNoClick(e);
    }
});

// Update addToCart function
function addToCart(id, name, price) {
    // Check localStorage again in case of navigation
    const storedAge = localStorage.getItem('ageVerified');
    if (storedAge !== 'true' && !ageVerified) {
        showNotification('Please verify your age first.', 'error');
        return;
    }

    if (typeof cart !== 'undefined') {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ id, name, price, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
        showNotification(`${name} added to cart!`);
    }
}

// Enhanced notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.textContent = message;
    
    const bgColor = type === 'error' ? '#dc3545' : '#28a745';
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        z-index: 10001;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        font-weight: 600;
        animation: slideInRight 0.3s ease-out;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add CSS for animations and page blocking
const styles = document.createElement('style');
styles.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .page-blocked {
        pointer-events: none !important;
        opacity: 0.3 !important;
        filter: blur(2px) !important;
    }
    
    #ageModal button {
        cursor: pointer !important;
        pointer-events: all !important;
    }
`;
document.head.appendChild(styles);

// Debug functions
window.checkAgeStatus = function() {
    console.log('Current ageVerified:', ageVerified);
    console.log('localStorage ageVerified:', localStorage.getItem('ageVerified'));
    console.log('Event listeners setup:', eventListenersSetup);
};

window.resetAgeVerification = function() {
    localStorage.removeItem('ageVerified');
    ageVerified = false;
    eventListenersSetup = false;
    console.log('Age verification reset - refresh page to see modal again');
};

window.forceShowModal = function() {
    ageVerified = false;
    eventListenersSetup = false;
    showAgeModal();
    blockPage();
    console.log('Modal forced to show');
};

// Page visibility change handler - for when user comes back to tab
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        console.log('Page became visible, checking age verification...');
        const storedAge = localStorage.getItem('ageVerified');
        if (storedAge === 'true') {
            ageVerified = true;
            const modal = document.getElementById('ageModal');
            if (modal && modal.style.display === 'flex') {
                hideAgeModal();
            }
        }
    }
});

function scrollToProducts() {
  var productsSection = document.getElementById('products');
  if (productsSection) {
    productsSection.scrollIntoView({ behavior: 'smooth' });
  }
}

// --- Animasi Scroll Reveal ---
function revealOnScroll() {
    // Section titles
    document.querySelectorAll('.section-title').forEach(function(el) {
        if (isInViewport(el)) {
            el.classList.add('visible');
        }
    });
    // Produk
    document.querySelectorAll('.product-card').forEach(function(el, i) {
        if (isInViewport(el)) {
            setTimeout(() => el.classList.add('visible'), i * 80);
        }
    });
    // Brand logo
    document.querySelectorAll('.brands img').forEach(function(el, i) {
        if (isInViewport(el)) {
            setTimeout(() => el.classList.add('visible'), i * 100);
        }
    });
    // Hero
    document.querySelectorAll('.hero-text, .hero-image').forEach(function(el, i) {
        if (isInViewport(el)) {
            setTimeout(() => el.style.opacity = 1, i * 200);
        }
    });
}
function isInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top < window.innerHeight - 40 &&
        rect.bottom > 0
    );
}
window.addEventListener('scroll', revealOnScroll);
window.addEventListener('DOMContentLoaded', function() {
    // Set initial opacity for hero
    document.querySelectorAll('.hero-text, .hero-image').forEach(function(el) {
        el.style.opacity = 0;
    });
    setTimeout(revealOnScroll, 200);
});

// Star rating interaktif untuk Contact Us
(function() {
    var stars = document.querySelectorAll('#contactStarRating .star');
    var ratingInput = document.getElementById('contactRatingInput');
    var selected = 0;
    if (stars.length) {
        stars.forEach(function(star, idx) {
            star.addEventListener('mouseenter', function() {
                highlightStars(idx+1);
            });
            star.addEventListener('mouseleave', function() {
                highlightStars(selected);
            });
            star.addEventListener('click', function() {
                selected = idx+1;
                ratingInput.value = selected;
                highlightStars(selected);
            });
        });
        function highlightStars(n) {
            stars.forEach(function(star, i) {
                star.textContent = i < n ? '★' : '☆';
                star.style.color = i < n ? '#ffc107' : '#ddd';
            });
        }
    }
})();

// Auto-hide contact success notification
(function() {
    var notif = document.getElementById('contactSuccessMsg');
    if (notif) {
        setTimeout(function() {
            notif.style.opacity = 0;
            setTimeout(function() {
                notif.style.display = 'none';
            }, 600);
        }, 4000);
    }
})();
   </script>

<?php $this->load->view('template/logout_modal'); ?>

<a href="https://wa.me/6281212151263" target="_blank" id="wa-float-btn" title="Chat via WhatsApp">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- WhatsApp Logo -->
            <path d="M16 2C8.268 2 2 8.268 2 16c0 2.567.692 5.012 2.01 7.15L2.5 29.5l6.35-1.51A13.94 13.94 0 0 0 16 30c7.732 0 14-6.268 14-14S23.732 2 16 2z" fill="#25D366"/>
            <path d="M25.2 15.9c0 5.1-4.1 9.2-9.2 9.2-1.6 0-3.1-.4-4.4-1.2l-3.1.8.8-3c-.8-1.4-1.3-3-1.3-4.8 0-5.1 4.1-9.2 9.2-9.2s9.2 4.1 9.2 9.2z" fill="#25D366"/>
            <path d="M23.1 15.9c0 3.9-3.2 7.1-7.1 7.1-1.2 0-2.4-.3-3.4-.9l-2.4.6.6-2.3c-.6-1.1-1-2.3-1-3.6 0-3.9 3.2-7.1 7.1-7.1s7.1 3.2 7.1 7.1z" fill="white"/>
            <path d="M20.3 18.7c-.2-.1-1.1-.5-1.3-.6-.2-.1-.3-.1-.4.1-.1.2-.5.6-.6.7-.1.1-.2.1-.4 0-.2-.1-.8-.3-1.5-.9-.6-.5-.9-1.1-1-1.3-.1-.2 0-.3.1-.4.1-.1.2-.2.2-.3.1-.1.1-.2.1-.2.1-.1 0-.2 0-.3-.1-.1-.4-1-.6-1.4-.2-.4-.4-.3-.4-.3h-.3c-.1 0-.3.1-.5.2-.2.2-.6.6-.6 1.4s.6 1.6.7 1.7c.1.1 1.2 1.8 2.9 2.5.4.2.7.3 1 .4.4.1.8.1 1.1.1.3 0 1-.4 1.1-.8.1-.4.1-.7.1-.8-.1-.1-.2-.2-.4-.3z" fill="#25D366"/>
        </svg>
    </a>

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        #wa-float-btn {
            position: fixed;
            right: 28px;
            bottom: 28px;
            z-index: 9999;
            background: #25D366;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse 2s infinite;
        }
        
        #wa-float-btn:hover {
            box-shadow: 0 8px 32px rgba(37,211,102,0.4);
            transform: scale(1.1);
            background: #22c35e;
        }
        
        #wa-float-btn svg {
            width: 32px;
            height: 32px;
            display: block;
        }
        
        /* Pulse animation for attention */
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            }
            50% {
                box-shadow: 0 4px 16px rgba(37,211,102,0.4), 0 0 0 8px rgba(37,211,102,0.1);
            }
            100% {
                box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            }
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            #wa-float-btn {
                right: 20px;
                bottom: 20px;
                width: 52px;
                height: 52px;
            }
            
            #wa-float-btn svg {
                width: 28px;
                height: 28px;
            }
        }
    </style>

<!-- Tambahkan modal foto profil di bawah navbar -->
<div id="profilePhotoModal" style="display:none;position:fixed;z-index:10001;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.7);align-items:center;justify-content:center;">
  <div style="position:relative;max-width:90vw;max-height:90vh;display:flex;align-items:center;justify-content:center;">
    <img id="profilePhotoModalImg" src="" alt="Foto Profil Besar" style="max-width:90vw;max-height:80vh;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.25);background:#fff;">
    <button onclick="closeProfileModal()" style="position:absolute;top:-18px;right:-18px;background:#fff;border:none;border-radius:50%;width:36px;height:36px;box-shadow:0 2px 8px rgba(0,0,0,0.15);font-size:1.5rem;cursor:pointer;">&times;</button>
  </div>
</div>
<script>
function showProfileModal(imgSrc) {
  var modal = document.getElementById('profilePhotoModal');
  var img = document.getElementById('profilePhotoModalImg');
  if (modal && img) {
    img.src = imgSrc;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
}
function closeProfileModal() {
  var modal = document.getElementById('profilePhotoModal');
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }
}
document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('profilePhotoModal');
  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === modal) closeProfileModal();
    });
  }
});
</script>
</body>
</html>