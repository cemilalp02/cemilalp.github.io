<?php
session_start();
$id = $_POST['id'] ?? '';
$fileT = __DIR__ . '/forum_topics.json';
$fileR = __DIR__ . '/forum_replies.json';

$topics = file_exists($fileT) ? json_decode(file_get_contents($fileT), true) : [];
$repl   = file_exists($fileR) ? json_decode(file_get_contents($fileR), true) : [];

foreach ($topics as $k=>$t) {
    $owner  = ($_SESSION['user']['email'] ?? '') === ($t['email'] ?? '');
    $admin  = ($_SESSION['user']['role'] ?? '') === 'admin';
    if ($t['id'] === $id && ($owner || $admin)) {
        unset($topics[$k]);
        // ilgili yorumları da sil
        $repl = array_filter($repl, fn($r)=>$r['topic'] !== $id);
        file_put_contents($fileT, json_encode(array_values($topics), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        file_put_contents($fileR, json_encode(array_values($repl),   JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        exit('deleted');
    }
}
http_response_code(403);
