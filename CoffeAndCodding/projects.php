<?php
/* =======================================================
   projects.php  – Coffee & Coding / Projects (with dynamic submissions)
   ======================================================= */
session_start();
$isLoggedIn  = isset($_SESSION['user']);
$user        = $_SESSION['user']['name'] ?? null;

// Load submissions from JSON file
$subFile     = __DIR__ . '/submissions.json';
$submissions = file_exists($subFile)
    ? json_decode(file_get_contents($subFile), true)
    : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee &amp; Coding – Projects</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Global CSS -->
  <link rel="stylesheet" href="style.css">

  
</head>
<body class="projects-page">
  <!-- ===== NAVBAR  ===== -->
  <nav class="navbar">
    <div class="container nav-content">
      <a href="index.php" class="logo">Coffee &amp; Coding</a>
      <ul class="nav-links">
        <li><a href="index.php"         <?= basename($_SERVER['PHP_SELF'])==='index.php'   ? 'class="active"' : '' ?>>Home</a></li>
        <li><a href="projects.php"      <?= basename($_SERVER['PHP_SELF'])==='projects.php'? 'class="active"' : '' ?>>Projects</a></li>
        <li><a href="activities.php"    <?= basename($_SERVER['PHP_SELF'])==='activities.php'? 'class="active"' : '' ?>>Activities</a></li>
        <li><a href="forum.php"         <?= basename($_SERVER['PHP_SELF'])==='forum.php'   ? 'class="active"' : '' ?>>Forum</a></li>
        <li><a href="faq.php"           <?= basename($_SERVER['PHP_SELF'])==='faq.php'     ? 'class="active"' : '' ?>>FAQ</a></li>
        <li><a href="support.php"       <?= basename($_SERVER['PHP_SELF'])==='support.php' ? 'class="active"' : '' ?>>Support</a></li>
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
      <!-- === Project 1: Personal Portfolio === -->
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

        <div class="project-submissions">
          <h4>Submissions:</h4>
          <ul>
            <?php
              $subs = array_filter(
                $submissions,
                fn($s) => $s['project'] === 'portfolio_website'
              );
              if (empty($subs)) {
                echo '<li>No submissions yet.</li>';
              } else {
                foreach ($subs as $s) {
                  echo '<li>'
                     . '<a href="uploads/' . htmlspecialchars($s['file']) . '" target="_blank">'
                     . htmlspecialchars($s['file'])
                     . '</a> by ' . htmlspecialchars($s['user'])
                     . ' on ' . date('Y-m-d H:i', strtotime($s['submitted']))
                     . '</li>';
                }
              }
            ?>
          </ul>
        </div>
      </div>

      <!-- === Project 2: CoffeeShop Companion === -->
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

        <div class="project-submissions">
          <h4>Submissions:</h4>
          <ul>
            <?php
              $subs = array_filter(
                $submissions,
                fn($s) => $s['project'] === 'coffeeshop_app'
              );
              if (empty($subs)) {
                echo '<li>No submissions yet.</li>';
              } else {
                foreach ($subs as $s) {
                  echo '<li><a href="uploads/' . htmlspecialchars($s['file']) . '" target="_blank">'
                     . htmlspecialchars($s['file'])
                     . '</a> by ' . htmlspecialchars($s['user'])
                     . ' on ' . date('Y-m-d H:i', strtotime($s['submitted']))
                     . '</li>';
                }
              }
            ?>
          </ul>
        </div>
      </div>

      <!-- === Project 3: Cybersec System === -->
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

        <div class="project-submissions">
          <h4>Submissions:</h4>
          <ul>
            <?php
              $subs = array_filter(
                $submissions,
                fn($s) => $s['project'] === 'cybersec_system'
              );
              if (empty($subs)) {
                echo '<li>No submissions yet.</li>';
              } else {
                foreach ($subs as $s) {
                  echo '<li><a href="uploads/' . htmlspecialchars($s['file']) . '" target="_blank">'
                     . htmlspecialchars($s['file'])
                     . '</a> by ' . htmlspecialchars($s['user'])
                     . ' on ' . date('Y-m-d H:i', strtotime($s['submitted']))
                     . '</li>';
                }
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="container footer-content">
      <p>&copy; 2025 Coffee &amp; Coding | All Rights Reserved</p>
    </div>
  </footer>
</body>
</html>
