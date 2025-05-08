<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.html'); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); exit;
}

$topic_id = trim($_POST['topic_id']);
$content  = trim($_POST['content']);
$author   = $_SESSION['user']['name'] ?? $_SESSION['user']['email'];
$ts       = date('c');

// Append reply
$postsFile = __DIR__ . '/forum_posts.json';
$posts = file_exists($postsFile)
    ? json_decode(file_get_contents($postsFile), true)
    : [];
$posts[] = [
    'id'         => uniqid(),
    'topic_id'   => $topic_id,
    'content'    => $content,
    'author'     => $author,
    'created_at' => $ts
];
file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));

header("Location: topic.php?id=$topic_id"); exit;