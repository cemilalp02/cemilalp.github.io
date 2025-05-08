<?php
session_start();
if (($_SESSION['user']['role'] ?? '') !== 'admin') { http_response_code(403); exit; }
$id = $_POST['id'] ?? null;
if (!$id) { http_response_code(400); exit; }

$file = __DIR__ . '/forum_topics.json';
$all  = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

foreach ($all as &$t) {
    if ($t['id'] === $id) {
        $t['pinned'] = !($t['pinned'] ?? false);
        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        echo json_encode(['pinned'=>$t['pinned']]);
        exit;
    }
}
http_response_code(404);
