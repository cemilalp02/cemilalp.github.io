<?php
session_start();
$id = $_POST['id'] ?? '';
if (!$id || empty($_POST['title']) || empty($_POST['category'])) { http_response_code(400); exit; }

$file = __DIR__ . '/forum_topics.json';
$all  = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

foreach ($all as &$t) {
    $isOwner = ($_SESSION['user']['email'] ?? '') === ($t['email'] ?? '');
    $isAdmin = ($_SESSION['user']['role'] ?? '') === 'admin';
    if ($t['id'] === $id && ($isOwner || $isAdmin)) {
        $t['title']    = htmlspecialchars($_POST['title']);
        $t['category'] = htmlspecialchars($_POST['category']);
        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        exit('success');
    }
}
http_response_code(403);
