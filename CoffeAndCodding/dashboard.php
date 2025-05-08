<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.html');
  exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
      <p>You are logged in as <strong><?php echo htmlspecialchars($user['email']); ?></strong>.</p>
      <a href="logout.php" class="login-button" style="display:inline-block;">Log out</a>
    </div>
  </div>
</body>
</html>
