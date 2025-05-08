<?php
session_start();
if (!isset($_SESSION['user']))          { http_response_code(403);  exit('login'); }
if (empty($_POST['topic']) || empty($_POST['msg'])) {
  http_response_code(400); exit('missing');
}

$file = __DIR__ . '/forum_replies.json';
$repl = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$repl[] = [
    'id'       => uniqid(),
    'topic'    => $_POST['topic'],
    'author'   => $_SESSION['user']['name'] ?? $_SESSION['user']['email'],
    'message'  => htmlspecialchars($_POST['msg']),
    'ts'       => date('c')
];

file_put_contents($file, json_encode($repl, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo 'success';
