<?php
session_start();
$user = $_SESSION['user']['name'] ?? null;
?>
<!DOCTYPE html>
<!--link :
https://talhasatir.github.io/CoffeAndCodding/index.html-->

<!-- Activities page for Coffee &amp; Coding -->
<html lang="en">
<head>
  <!-- Meta information and title -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee &amp; Coding - Activities</title>

  <!-- Google Fonts preconnect and stylesheet -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  
  <!-- Main stylesheet -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- ===== NAVBAR ===== -->
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
  <!-- Main Content: Activities Listing -->
  <main class="container">
    <h1>Activities</h1>
    <p>Discover our exciting activities and upcoming events designed for coding enthusiasts.</p>
    
    <div class="activities-container">
      <div class="activity">
        <h3>Weekly Coding and Coffee Challenges</h3>
        <p>Test your problem-solving skills and improve your coding abilities with our weekly challenges with friends.</p>
      </div>
      <div class="activity">
        <h3>Hackathons</h3>
        <p>Participate in hackathons and collaborate with fellow developers to build amazing projects.</p>
      </div>
    </div>
  </main>

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
</body>
</html>
