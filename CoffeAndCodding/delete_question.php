<?php
session_start();
header('Content-Type: application/json');

$id = $_POST['id'] ?? '';
if (!$id) { http_response_code(400); exit; }

$file = __DIR__.'/questions.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$data = array_values(array_filter($data, fn($q)=>$q['id']!==$id));
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(['success'=>true]);
