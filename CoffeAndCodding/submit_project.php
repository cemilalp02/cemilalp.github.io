<?php
/* submit_project.php – only logged in user can submit files */
session_start();

if (!isset($_SESSION['user'])) {
 
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || empty($_FILES['submission']['name'])
    || empty($_POST['project_id'])) {
    http_response_code(400);
    exit('Bad request');
}

/* ---- 1) Simply verify the file type ---- */
$allowed = ['zip','rar','7z','pdf','doc','docx','ppt','pptx','png','jpg','jpeg'];
$ext = strtolower(pathinfo($_FILES['submission']['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    exit('Unsupported file type.');
}

/* ---- 2) Safe target file name and upload ---- */
$uploadsDir = __DIR__.'/uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0775, true);
}
$cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/','', $_FILES['submission']['name']);
$target    = $uploadsDir . '/' . time() . '_' . $cleanName;

if (!move_uploaded_file($_FILES['submission']['tmp_name'], $target)) {
    exit('Upload failed – try again.');
}

/* ---- 3) Keep the submission record in JSON ---- */
$logFile = __DIR__.'/submissions.json';
$log     = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

$log[] = [
    'user'      => $_SESSION['user']['email'],
    'project'   => $_POST['project_id'],
    'file'      => basename($target),
    'submitted' => date('c')
];
file_put_contents($logFile, json_encode($log, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

/* ---- 4) Simple success message ---- */
echo '<h2>Submission successful ✔️</h2>
      <p><a href="projects.php">Back to Projects</a></p>';
