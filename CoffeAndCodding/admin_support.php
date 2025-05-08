<?php
session_start();

// if (!isset($_SESSION['user'])) { header('Location: login.html'); exit; }
$dataFile = __DIR__ . '/contacts.json';
$requests = file_exists($dataFile)
          ? json_decode(file_get_contents($dataFile), true)
          : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin – Support Requests</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table { width:100%; border-collapse:collapse; margin-top:1rem; }
    th, td { padding:0.5rem; border:1px solid #ddd; text-align:left; }
    th { background:#f0f0f0; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container" style="padding:2rem 0;">
    <h1>Support Requests</h1>
    <?php if (empty($requests)): ?>
      <p>No requests yet.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Topic</th>
            <th>Message</th>
            <th>Submitted At</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($requests as $i => $r): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= htmlspecialchars($r['phone']) ?></td>
            <td><?= htmlspecialchars($r['preferred_date']) ?></td>
            <td><?= htmlspecialchars($r['topic']) ?></td>
            <td><?= nl2br(htmlspecialchars($r['message'])) ?></td>
            <td><?= htmlspecialchars($r['submitted_at']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
