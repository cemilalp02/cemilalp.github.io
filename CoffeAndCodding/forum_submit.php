<?php
session_start();
if (!isset($_SESSION['user'])) { http_response_code(403); exit('login'); }
if ($_SERVER['REQUEST_METHOD']!=='POST' || empty($_POST['title'])||empty($_POST['category'])){
  http_response_code(400); exit('bad');
}
$file = __DIR__.'/forum_topics.json';
$data = file_exists($file)?json_decode(file_get_contents($file), true):[];
$id = uniqid();
$data[]=[
  'id'=>$id,
  'title'=>htmlspecialchars($_POST['title']),
  'category'=>htmlspecialchars($_POST['category']),
  'author'=>$_SESSION['user']['name']??$_SESSION['user']['email'],
  'timestamp'=>date('c'),
  'likes'=>0,
  'pinned'=>false
];
file_put_contents($file,json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo $id;
?>
