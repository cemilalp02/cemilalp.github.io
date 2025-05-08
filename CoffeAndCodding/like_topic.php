<?php
session_start();
if (!isset($_POST['id']))               { http_response_code(400); exit; }

$id   = $_POST['id'];
$file = __DIR__ . '/forum_topics.json';
$all  = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

foreach ($all as &$t) {
    if ($t['id'] === $id) {
       // Session based “has he/she liked it before?” control
        $_SESSION['liked'] = $_SESSION['liked'] ?? [];
        $liked = in_array($id, $_SESSION['liked'], true);

        // update the counter
        $t['likes'] = $t['likes'] ?? 0;
        $t['likes'] += $liked ? -1 : +1;

        // toggle keep in list
        if ($liked)  $_SESSION['liked'] = array_diff($_SESSION['liked'], [$id]);
        else         $_SESSION['liked'][] = $id;

        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        echo json_encode(['likes'=>$t['likes'], 'liked'=>!$liked]);
        exit;
    }
}
http_response_code(404);
