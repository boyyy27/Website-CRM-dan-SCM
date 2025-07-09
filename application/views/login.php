<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/png" href="https://i.ibb.co/Fkx7FzKJ/Pngtree-vape-device-8133386.png" />


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up - ZE Vapestore</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
    }

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
      font-weight: bold;
      font-size: 1.5rem;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 2rem;
      margin: 0;
      padding: 0;
      align-items: center;
    }

    nav ul li {
      font-weight: 600;
      font-size: 1rem;
    }

    nav ul li a {
      text-decoration: none;
      color: #000;
    }

    nav ul li a:hover {
      color: #007bff;
    }

    .register-container {
      max-width: 400px;
      margin: 4rem auto;
      background-color: #e6e6e6;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 1rem;
      font-weight: 700;
      border-bottom: 2px solid #000;
      padding-bottom: 0.5rem;
    }

    label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.3rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button.register-btn {
      margin-top: 1.5rem;
      width: 100%;
      background-color: #000;
      color: #fff;
      padding: 0.7rem;
      border: none;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
      transition: background-color 0.3s ease;
    }

    button.register-btn:hover {
      background-color: #333;
    }

    .login-link {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .login-link a {
      color: #000;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

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
      color: #bdc3c7;
    }

    footer .footer-links ul li {
      margin-bottom: 0.5rem;
      cursor: pointer;
      color: #bdc3c7;
      transition: color 0.3s ease;
    }

    footer .footer-links ul li:hover {
      color: rgb(230, 232, 233);
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
  </style>
</head>

<body>
  <nav>
  <div class="logo" style="display: flex; align-items: center; gap: 10px;">
      <a href="<?= base_url('index.php/Welcome/landing') ?>" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
        <img src="<?= base_url('assets/gambar/vape.png') ?>" alt="Vape Logo" style="width:36px; height:36px; border-radius:50%; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
        ZE VapeStore
      </a>
    </div>

    <ul>
      <li><a href="<?php echo base_url('index.php/Welcome/landing'); ?>">Home</a></li>
      <li><a href="<?php echo base_url('index.php/Welcome/products'); ?>">Product</a></li>
      <li><a href="<?php echo base_url('index.php/Welcome/landing#about'); ?>">About us</a></li>
      <li><a href="<?php echo base_url('index.php/Welcome/landing#contact-us'); ?>">Contact</a></li>
    </ul>
  </nav>

   <div class="register-container">
    <h2>Login</h2>


    <!-- Menampilkan pesan error jika login gagal -->
    <?php if ($this->session->flashdata('message')): ?>
      <div class="alert alert-danger">
        <?php echo $this->session->flashdata('message'); ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo base_url('index.php/Auth/submit_login'); ?>" method="post">
      <label for="username_or_email">Username or E-mail</label>
      <input type="text" id="username_or_email" name="username_or_email" placeholder="Masukkan username atau email" required value="<?php echo set_value('username_or_email'); ?>" />
      <?php echo form_error('username_or_email'); ?>

      <label for="password">Password</label>
      <input type="password" id="password" placeholder="Masukkan password" name="password" required />
      <?php echo form_error('password'); ?>

      <button type="submit" class="register-btn">Login</button>
    </form>

    <div class="login-link">
      Don't have an account? <a href="<?php echo base_url('index.php/Auth/signup'); ?>">Sign up</a>
    </div>
  </div>

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
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#coupons">Coupons</a></li>
            <li><a href="#blog">Blog Posts</a></li>
            <li><a href="#return-policy">Return Policy</a></li>
            <li><a href="#affiliate">Join Affiliate</a></li>
          </ul>
        </div>
        <div>
          <h4>Follow Us</h4>
          <ul>
            <li><a href="#facebook">Facebook</a></li>
            <li><a href="#twitter">Twitter</a></li>
            <li><a href="#instagram">Instagram</a></li>
            <li><a href="#youtube">Youtube</a></li>
          </ul>
        </div>
      </div>
    </div>
    <hr />
    <div class="copyright">
      <p>&copy; <?= date('Y') ?> ZE Vapestore. All rights reserved. | Age restricted - 21+ only</p>
    </div>
  </footer>

</html>