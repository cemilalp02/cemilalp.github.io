<?php
session_start();
$user = $_SESSION['user']['name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta information -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coffee &amp; Coding - Home</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
    rel="stylesheet"
  />

  <!-- Main stylesheet -->
  <link rel="stylesheet" href="style.css" />

  <!-- jQuery (for AJAX) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<!-- ===== NAVBAR – ortak ===== -->
<nav class="navbar">
  <div class="container nav-content">
    <a href="index.php" class="logo">Coffee &amp; Coding</a>

    <ul class="nav-links">
      <li><a href="index.php"            <?= basename($_SERVER['PHP_SELF'])==='index.php'      ?'class="active"':'' ?>>Home</a></li>
      <li><a href="projects.php"        <?= basename($_SERVER['PHP_SELF'])==='projects.php'    ?'class="active"':'' ?>>Projects</a></li>
      <li><a href="activities.php"      <?= basename($_SERVER['PHP_SELF'])==='activities.php'  ?'class="active"':'' ?>>Activities</a></li>
      <li><a href="forum.php"           <?= basename($_SERVER['PHP_SELF'])==='forum.php'       ?'class="active"':'' ?>>Forum</a></li>
      <li><a href="faq.php"             <?= basename($_SERVER['PHP_SELF'])==='faq.php'         ?'class="active"':'' ?>>FAQ</a></li>
      <li><a href="support.php"         <?= basename($_SERVER['PHP_SELF'])==='support.php'     ?'class="active"':'' ?>>Support</a></li>
      <li><a href="index.php#about">About Us</a></li>
      <li><a href="index.php#contact">Contact</a></li>

      <?php if ($user): ?>
        <li style="display:flex;align-items:center;gap:.5rem;">
          <span style="color:#fff;">Hi, <?= htmlspecialchars($user) ?>!</span>
          <a href="logout.php" class="btn-login" style="background:#dc3545;">Log out</a>
        </li>
      <?php else: ?>
        <li><a href="signup.html" class="btn-login">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

  <!-- Hero Section -->
  <header class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content container">
      <h1>Welcome to Coffee &amp; Coding</h1>
      <p>Where code meets caffeine — fueling innovation one sip at a time.</p>
      <a href="#featured" class="btn-cta">Explore Our Projects</a>
    </div>
  </header>

  <!-- Featured Projects Section -->
  <section id="featured" class="featured container">
    <h2>Featured Projects</h2>
    <div class="cards">
    <div class="card">
      <h3>AI-Powered Code Review Bot</h3>
      <p>Quick description or highlight of this project...</p>
     <!-- 1. Redirect to project detail page -->
      <a href="project-ai-review.html" class="btn-secondary">Learn More</a>
    </div>
      <div class="card">
      <h3>CoffeeShop Companion App</h3>
      <p>Brief overview of the project...</p>
      <a href="project-coffeeshop.html" class="btn-secondary">Learn More</a>
    </div>

    <div class="card">
      <h3>Cyber Attack Detection & Response System</h3>
      <p>Explore the details and see how you can contribute...</p>
      <a href="project-cybersec.html" class="btn-secondary">Learn More</a>
    </div>
    </div>
  </section>

  <!-- AJAX Section: Sprint 4 Part I -->
  <section id="ajax-section" class="container" style="padding: 3rem 0;">
    <h2>📢 Site News</h2>
    <ul id="news-list">
      <!-- to be loaded from data/news.json -->
    </ul>

    <h2>🎙️ Quote of the Day (Technology)</h2>
    <blockquote id="tech-quote">
      Loading…
    </blockquote>
  </section>

  <!-- About Section -->
  <section id="about" class="about container">
    <h2>About Coffee &amp; Coding</h2>
    <p>
      We believe the best code is written with a warm cup in hand. Our community of developers
      and coffee lovers come together to share projects, tutorials, and plenty of caffeine tips.
    </p>
    <p>
      Join us in our events, explore tutorials, or jump into our forum to discuss your next big idea.
    </p>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact container">
    <h2>Contact</h2>
    <p>We'd love to hear from you. Reach out for inquiries, collaborations, or just to say hello!</p>
    <div class="contact-cards">
      <div class="contact-card">
        <h3>Address</h3>
        <p>123 Coffee Lane, Istanbul, Turkey</p>
      </div>
      <div class="contact-card">
        <h3>Email</h3>
        <p>info@coffeeandcoding.com</p>
      </div>
      <div class="contact-card">
        <h3>Phone</h3>
        <p>+90 555 123 4567</p>
      </div>
    </div>
  </section>

  <!-- Footer Section -->
  <footer class="footer">
    <div class="container footer-content">
      <p>&copy; 2025 Coffee &amp; Coding | All Rights Reserved</p>
      <div class="social-links">
        <a href="https://github.com/cemilalp02" target="_blank">
          <img src="images/github_2504911.png" alt="GitHub" class="social-icon">
        </a>
      </div>
    </div>
  </footer>

  <!-- Separate file for AJAX scripts -->
  <script src="ajax.js"></script>
</body>
</html>
