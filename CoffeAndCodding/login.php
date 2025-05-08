<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$email    = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
  die('Email and password required. <a href="login.html">Back</a>');
}

$users = json_decode(file_get_contents(__DIR__.'/users.json'), true) ?? [];

foreach ($users as $u) {
  if ($u['email'] === $email && password_verify($password, $u['password'])) {
    $_SESSION['user'] = ['name'=>$u['name'],'email'=>$u['email']];
    header('Location: index.php');   // <-- değiştirildi
    exit;
  }
}
echo 'Incorrect email or password. <a href="login.html">Try again</a>';
