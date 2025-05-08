<?php
// submit_question.php – save into questions.json for FAQ
session_start();

// only logged-in users can ask
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit(json_encode(['error'=>'Login required']));
}

// must be POST with non-empty question
if ($_SERVER['REQUEST_METHOD']!=='POST'
    || empty(trim($_POST['question'] ?? ''))) {
    http_response_code(400);
    exit(json_encode(['error'=>'Bad request']));
}

$qText = trim($_POST['question']);
$user  = $_SESSION['user']['name'] ?? $_SESSION['user']['email'];

// load existing FAQs
$file = __DIR__ . '/questions.json';
$faq  = file_exists($file)
      ? json_decode(file_get_contents($file), true)
      : [];

// append new entry
$faq[] = [
    'id'       => uniqid(),           
    'author'   => $user,              
    'question' => $qText,
    'answer'   => ''                  
];

// write back to questions.json
file_put_contents($file,
    json_encode($faq, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)
);

// respond with success so AJAX can reload
header('Content-Type: application/json');
echo json_encode(['success'=>true]);
