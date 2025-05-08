<?php
/* signup.php – Registers a new user */

header('Content-Type: text/html; charset=utf-8');
$required = ['name','surname','email','phone','password'];
foreach ($required as $f) {
  if (empty($_POST[$f])) {
    die('All fields are required. <a href="signup.html">Back</a>');
  }
}

$name     = htmlspecialchars(trim($_POST['name']));
$surname  = htmlspecialchars(trim($_POST['surname']));
$email    = strtolower(trim($_POST['email']));
$phone    = htmlspecialchars(trim($_POST['phone']));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$filepath = __DIR__ . '/users.json';
$users = file_exists($filepath) ? json_decode(file_get_contents($filepath), true) : [];

/* Is the email already registered? */
foreach ($users as $u) {
  if ($u['email'] === $email) {
    die('Email already registered. <a href="signup.html">Back</a>');
  }
}

/* Add new user to array */
$users[] = [
  'name'     => $name,
  'surname'  => $surname,
  'email'    => $email,
  'phone'    => $phone,
  'password' => $password
];

/* Update JSON file */
file_put_contents($filepath, json_encode($users, JSON_PRETTY_PRINT));

echo 'Account created! <a href="login.html">Log in here</a>';
