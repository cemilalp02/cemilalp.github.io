<?php
/* =======================================================
   projects.php  – Coffee & Coding / Projects (with background image)
   ======================================================= */
session_start();
$isLoggedIn = isset($_SESSION['user']);
$user       = $_SESSION['user']['name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee & Coding – Projects</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Global + page-specific CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="projects-style.css">

  <style>
    /* ===== Full-screen Background ===== */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      z-index: -1;
      background: url('images/projects_bg.jpg') center/cover no-repeat fixed,
                  linear-gradient(135deg, #f3f1ec 0%, #dfd0bc 100%);
      opacity: 0.2;
    }

    /* ===== Projects Layout ===== */
    .projects-container {
      display: grid;
      gap: 2rem;
      margin-top: 2rem;
    }
    .project {
      padding: 1.5rem;
      background: rgba(255,255,255,0.9);
      border: 1px solid #ececec;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .submit-form input[type=file] {
      margin-top: .5rem;
    }
    .login-warning {
      margin-top: .8rem;
      color: #e74c3c;
    }
  </style>
</head>
<body>
<!-- ===== NAVBAR  ===== -->
<nav class="navbar">
  <div class="container nav-content">
    <a href="index.php" class="logo">Coffee &amp; Coding</a>
    <ul class="nav-links">
      <li><a href="index.php"         <?= basename($_SERVER['PHP_SELF'])==='index.php'      ?'class="active"':'' ?>>Home</a></li>
      <li><a href="projects.php"      <?= basename($_SERVER['PHP_SELF'])==='projects.php'    ?'class="active"':'' ?>>Projects</a></li>
      <li><a href="activities.php"    <?= basename($_SERVER['PHP_SELF'])==='activities.php'  ?'class="active"':'' ?>>Activities</a></li>
      <li><a href="forum.php"         <?= basename($_SERVER['PHP_SELF'])==='forum.php'       ?'class="active"':'' ?>>Forum</a></li>
      <li><a href="faq.php"           <?= basename($_SERVER['PHP_SELF'])==='faq.php'         ?'class="active"':'' ?>>FAQ</a></li>
      <li><a href="support.php"       <?= basename($_SERVER['PHP_SELF'])==='support.php'     ?'class="active"':'' ?>>Support</a></li>
      <li><a href="index.php#about">About Us</a></li>
      <li><a href="index.php#contact">Contact</a></li>

      <?php if ($isLoggedIn): ?>
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

<!-- ===== MAIN ===== -->
<main class="container">
  <h1>Projects</h1>
  <p>Explore our featured projects and submit your own implementations.</p>

  <div class="projects-container">
    <!-- === Project 1 === -->
    <div class="project">
      <h3>Personal Portfolio Website</h3>
      <p>Design and develop your personal portfolio website using HTML, CSS, and JavaScript.</p>

      <?php if ($isLoggedIn): ?>
        <form action="submit_project.php" method="post" enctype="multipart/form-data" class="submit-form">
          <input type="hidden" name="project_id" value="portfolio_website">
          <input type="file" name="submission" required>
          <button type="submit" class="btn upload-btn">Submit Project</button>
        </form>
      <?php else: ?>
        <p class="login-warning">
          Please <a href="login.html">log in</a> or <a href="signup.html">sign up</a> to submit.
        </p>
      <?php endif; ?>
    </div>

    <!-- === Project 2 === -->
    <div class="project">
      <h3>CoffeeShop Companion App</h3>
      <p>Web application for managing orders, inventory, and customer feedback.</p>

      <?php if ($isLoggedIn): ?>
        <form action="submit_project.php" method="post" enctype="multipart/form-data" class="submit-form">
          <input type="hidden" name="project_id" value="coffeeshop_app">
          <input type="file" name="submission" required>
          <button type="submit" class="btn upload-btn">Submit Project</button>
        </form>
      <?php else: ?>
        <p class="login-warning">
          Please <a href="login.html">log in</a> or <a href="signup.html">sign up</a> to submit.
        </p>
      <?php endif; ?>
    </div>

    <!-- === Project 3 === -->
    <div class="project">
      <h3>Cyber Attack Detection &amp; Response System</h3>
      <p>Machine-learning system that analyzes network traffic to detect and respond to threats.</p>

      <?php if ($isLoggedIn): ?>
        <form action="submit_project.php" method="post" enctype="multipart/form-data" class="submit-form">
          <input type="hidden" name="project_id" value="cybersec_system">
          <input type="file" name="submission" required>
          <button type="submit" class="btn upload-btn">Submit Project</button>
        </form>
      <?php else: ?>
        <p class="login-warning">
          Please <a href="login.html">log in</a> or <a href="signup.html">sign up</a> to submit.
        </p>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- ===== FOOTER ===== -->
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

<script>
// Show filename on submit button
document.querySelectorAll('.submit-form input[type=file]').forEach(inp => {
  inp.addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) e.target.nextElementSibling.textContent = 'Submit (' + file.name + ')';
  });
});
</script>
</body>
</html>
