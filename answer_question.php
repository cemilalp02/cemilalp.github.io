<?php
session_start();
header('Content-Type: application/json');

$id     = $_POST['id'] ?? '';
$answer = trim($_POST['answer'] ?? '');

if (!$id || !$answer) {
  http_response_code(400);
  echo json_encode(['error'=>'id and answer required']);
  exit;
}

$file = __DIR__.'/questions.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

foreach ($data as &$q) {
  if ($q['id'] === $id) {
    $q['answer'] = htmlspecialchars($answer);
    break;
  }
}
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(['success'=>true]);
