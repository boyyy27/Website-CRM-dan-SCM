<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RK Vapestore</title>
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
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
        }
        nav .logo {
            display: flex;
            align-items: center;
        }
        nav .logo img {
            height: 40px;
            width: 40px;
            margin-right: 0.5rem;
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
        }
        nav ul li.cart-icon {
            font-size: 1.5rem;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .hero-text {
            max-width: 50%;
        }
        .hero-text h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero-text p {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #333;
        }
        .btn-explore {
            background-color: #000;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-explore:hover {
            background-color: #333;
        }
        .btn-explore svg {
            margin-left: 0.5rem;
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
        .hero-image img {
            max-width: 300px;
            height: auto;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            font-weight: 700;
            font-size: 1.25rem;
            margin: 3rem 0 1rem 0;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: "";
            display: block;
            width: 50px;
            height: 3px;
            background: #000;
            margin: 0.5rem auto 0 auto;
            border-radius: 2px;
        }

        /* Products Grid */
        .products-grid {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto 3rem auto;
            padding: 0 1rem;
        }
        .product-card {
            width: 180px;
            text-align: center;
            font-size: 0.9rem;
        }
        .product-card img {
            width: 100%;
            height: auto;
            margin-bottom: 0.5rem;
        }
        .product-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .product-rating {
            color: #f5a623;
            margin-bottom: 0.25rem;
        }
        .product-price {
            font-weight: 600;
            color: #333;
        }

        /* Star rating */
        .star {
            display: inline-block;
            width: 16px;
            height: 16px;
            background: url('data:image/svg+xml;utf8,<svg fill="%23f5a623" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M287.9 17.8L354 150.2 499.2 171.5C522.6 174.3 531.6 202.6 514.6 217.7L405.4 305.4 433.8 450.6C437.7 474 414.6 490.9 394.6 479.8L288 439.6 181.4 479.8C161.4 490.9 138.3 474 142.2 450.6L170.6 305.4 61.4 217.7C44.4 202.6 53.4 174.3 76.8 171.5L222 150.2 288.1 17.8C295.4 3.4 312.6 3.4 319.9 17.8z"/></svg>') no-repeat center center;
            background-size: contain;
        }
        .star.empty {
            background: url('data:image/svg+xml;utf8,<svg fill="%23ccc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M287.9 17.8L354 150.2 499.2 171.5C522.6 174.3 531.6 202.6 514.6 217.7L405.4 305.4 433.8 450.6C437.7 474 414.6 490.9 394.6 479.8L288 439.6 181.4 479.8C161.4 490.9 138.3 474 142.2 450.6L170.6 305.4 61.4 217.7C44.4 202.6 53.4 174.3 76.8 171.5L222 150.2 288.1 17.8C295.4 3.4 312.6 3.4 319.9 17.8z"/></svg>') no-repeat center center;
            background-size: contain;
        }

        /* Brand logos */
        .brands {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin: 3rem 0;
            flex-wrap: wrap;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        .brands img {
            height: 40px;
            object-fit: contain;
        }

        /* Footer */
        footer {
            background: #000;
            color: #fff;
            padding: 2rem 3rem;
            font-size: 0.9rem;
        }
        footer .footer-top {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        footer .app-download {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        footer .app-download img {
            height: 40px;
            cursor: pointer;
        }
        footer .footer-logo {
            text-align: center;
            flex: 1;
            margin: 0 2rem;
        }
        footer .footer-logo img {
            height: 60px;
            margin-bottom: 0.5rem;
        }
        footer .footer-logo p {
            font-size: 0.8rem;
            color: #ccc;
        }
        footer .footer-links {
            display: flex;
            gap: 3rem;
            flex: 1;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        footer .footer-links div {
            min-width: 120px;
        }
        footer .footer-links h4 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        footer .footer-links ul li {
            margin-bottom: 0.3rem;
            cursor: pointer;
            color: #ccc;
        }
        footer .footer-links ul li:hover {
            color: #fff;
        }
        footer hr {
            border: none;
            border-top: 1px solid #444;
            margin: 1rem 0 0 0;
        }
        footer .copyright {
            text-align: center;
            margin-top: 1rem;
            color: #666;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="https://i.ibb.co/7QpKsCX/logo.png" alt="RK Logo" />
            <span>RK</span>
        </div>
        <ul>
            <li>Home</li>
            <li>Product</li>
            <li>About us</li>
            <li>Contact</li>
            <li>Account</li>
            <li class="cart-icon">&#128722;</li>
        </ul>
    </nav>

    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to<br>RK vapestore</h1>
            <p>This is a Vape Store. If you’re underage, don’t visit this website.</p>
            <button class="btn-explore">
                Explore
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
        <div class="hero-image">
            <img src="https://i.ibb.co/3W2tNm8/vape.png" alt="Vape Device" />
        </div>
    </section>

    <h2 class="section-title">Featured Products</h2>
    <section class="products-grid">
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/geekvape-b100.png" alt="GeekVape B100" />
            <div class="product-name">GeekVape B100</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/jooze-strawberry.png" alt="JOOZE - Strawberry" />
            <div class="product-name">JOOZE - Strawberry</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/fremax-mpro2.png" alt="Freemax - M Pro 2" />
            <div class="product-name">Freemax - M Pro 2</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/hellvape-shoelace.png" alt="Hellvape Shoelace Organic Cotton" />
            <div class="product-name">Hellvape Shoelace Organic Cotton</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
    </section>

    <h2 class="section-title">Latest Products</h2>
    <section class="products-grid">
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/vaporesso-swag.png" alt="Vaporesso SWAG" />
            <div class="product-name">Vaporesso SWAG</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/lost-vape-ursa.png" alt="Lost Vape Ursa" />
            <div class="product-name">Lost Vape Ursa</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/fremax-m2pro.png" alt="Freemax - M2 Pro" />
            <div class="product-name">Freemax - M2 Pro</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
        <div class="product-card">
            <img src="https://i.ibb.co/7QpKsCX/jooze-menthol.png" alt="JOOZE - Menthol" />
            <div class="product-name">JOOZE - Menthol</div>
            <div class="product-rating">
                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star empty"></span><span class="star empty"></span>
            </div>
            <div class="product-price">$59.00</div>
        </div>
    </section>

    <section class="brands">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c6/Coca-Cola_logo.svg/1200px-Coca-Cola_logo.svg.png" alt="CocaCola" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Godrej_logo.svg" alt="Godrej" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9e/Oppo_logo.svg" alt="Oppo" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Philips_logo.svg" alt="Philips" />
    </section>

    <footer>
        <div class="footer-top">
            <div class="app-download">
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" /></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/67/App_Store_(iOS).svg" alt="App Store" /></a>
            </div>
            <div class="footer-logo">
                <img src="https://i.ibb.co/7QpKsCX/logo.png" alt="RK Logo" />
                <p>Getting money is our motive</p>
            </div>
            <div class="footer-links">
                <div>
                    <h4>Useful Links</h4>
                    <ul>
                        <li>Coupons</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                <div>
                    <h4>Follow Us</h4>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                        <li>Youtube</li>
                    </ul>
                </div>
            </div>
        </div>
        <hr />
        <div class="copyright">
            Copyright 2022 - Kurniawan & Ridho Al Walliyyu
        </div>
    </footer>
</body>
</html>
