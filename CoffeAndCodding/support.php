<?php
session_start();
$user      = $_SESSION['user']['name'] ?? null;
$loggedIn  = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<!--  Coffee & Coding – Support / Contact  -->
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coffee & Coding – Contact / Support</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Styles -->
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="support.css"/>

  <!-- jQuery-UI (Datepicker widget) -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"/>

  <!-- Toastr (notifications) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
</head>
<body>

<!-- ===== NAVBAR – ortak ===== -->
<nav class="navbar">
  <div class="container nav-content">
    <a href="index.php" class="logo">Coffee &amp; Coding</a>
    <ul class="nav-links">
      <li><a href="index.php"        <?= basename($_SERVER['PHP_SELF'])==='index.php'      ?'class="active"':'' ?>>Home</a></li>
      <li><a href="projects.php"     <?= basename($_SERVER['PHP_SELF'])==='projects.php'    ?'class="active"':'' ?>>Projects</a></li>
      <li><a href="activities.php"   <?= basename($_SERVER['PHP_SELF'])==='activities.php'  ?'class="active"':'' ?>>Activities</a></li>
      <li><a href="forum.php"        <?= basename($_SERVER['PHP_SELF'])==='forum.php'       ?'class="active"':'' ?>>Forum</a></li>
      <li><a href="faq.php"          <?= basename($_SERVER['PHP_SELF'])==='faq.php'         ?'class="active"':'' ?>>FAQ</a></li>
      <li><a href="support.php"      <?= basename($_SERVER['PHP_SELF'])==='support.php'     ?'class="active"':'' ?>>Support</a></li>
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

<div class="background-wrapper">
  <img src="images/image7.webp" alt="Support background" class="bg-image">
</div>

<main class="support-container container">
  <div class="support-info">
    <h1>Get in touch / Reserve your seat ☕</h1>
    <p>
      Fill in the form – or directly
      <a href="mailto:coffeeandcoding@example.com">send e-mail</a>.
    </p>
  </div>

  <div class="support-form-container">
    <?php if ($loggedIn): ?>
      <!-- ====== FORM: sadece giriş yapanlara ====== -->
      <form id="support-form" novalidate>
        <div class="form-row">
          <label for="first-name">First name*</label>
          <input type="text" id="first-name" name="first_name" required>
        </div>

        <div class="form-row">
          <label for="last-name">Last name*</label>
          <input type="text" id="last-name" name="last_name" required>
        </div>

        <div class="form-row">
          <label for="email">Email*</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-row">
          <label for="phone">Phone (+90 ___)*</label>
          <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-row">
          <label for="reservation-date">Preferred date</label>
          <input type="text" id="reservation-date" name="preferred_date">
        </div>

        <div class="form-row">
          <label for="topic">Topic</label>
          <select id="topic" name="topic">
            <option value="contact">General question</option>
            <option value="reservation">Reservation</option>
            <option value="comment">Product comment</option>
          </select>
        </div>

        <div class="form-row">
          <label for="message">Message / Details*</label>
          <textarea id="message" name="message" rows="4" required></textarea>
        </div>

        <div class="form-row">
          <label for="attachment">Attach file (optional)</label>
          <input type="file" id="attachment" name="attachment" accept=".zip,.rar,.7z,.png,.jpg,.jpeg,.pdf">
        </div>

        <button type="submit" class="request-btn">
          Send&nbsp;Request <span class="arrow-icon">&rarr;</span>
        </button>
      </form>
    <?php else: ?>
      <!-- ====== UYARI: giriş yok ====== -->
      <p style="color:#e74c3c; font-weight:600;">
        Please <a href="login.html">log in</a> or
        <a href="signup.html">sign up</a> to submit a support request.
      </p>
    <?php endif; ?>
  </div>
</main>

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

<!-- ▸ JAVASCRIPT RESOURCES -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="support.js"></script>
</body>
</html>
