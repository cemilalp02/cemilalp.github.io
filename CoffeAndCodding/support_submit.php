<?php
session_start();                           // ▲ Oturum başlat
if (!isset($_SESSION['user'])) {           // ▲ Sunucu tarafı ek kontrol
    http_response_code(403);
    exit('Login required');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// 1) Form verisini al ve kaydet
$entry = [
    'first_name'     => $_POST['first_name']     ?? '',
    'last_name'      => $_POST['last_name']      ?? '',
    'email'          => $_POST['email']          ?? '',
    'phone'          => $_POST['phone']          ?? '',
    'preferred_date' => $_POST['preferred_date'] ?? '',
    'topic'          => $_POST['topic']          ?? '',
    'message'        => $_POST['message']        ?? '',
    'submitted_at'   => date('c'),
    'file'           => null                     // ▲ dosya alanı eklendi
];

/* ▲ (isteğe bağlı) dosya yükleme */
if (!empty($_FILES['attachment']['name'])) {
    $allowed = ['zip','rar','7z','png','jpg','jpeg','pdf'];
    $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        $uploads = __DIR__ . '/uploads';
        if (!is_dir($uploads)) { mkdir($uploads, 0775, true); }
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '', basename($_FILES['attachment']['name']));
        $fileName = time() . '_' . $safeName;
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploads . '/' . $fileName)) {
            $entry['file'] = $fileName;
        }
    }
}

$file = __DIR__ . '/contacts.json';
$data = file_exists($file)
      ? json_decode(file_get_contents($file), true)
      : [];
$data[] = $entry;
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

// 2) Kullanıcıya otomatik e-posta gönder
$userTo      = $entry['email'];
$userSubject = 'Your support request at Coffee & Coding';
$userBody    = "Hi {$entry['first_name']},\n\n"
             . "Thanks for contacting Coffee & Coding.\n"
             . "We’ve received your request and will get back to you ASAP.\n\n"
             . "Your message:\n\"{$entry['message']}\"\n\n"
             . "Best,\nThe Coffee & Coding Team";
$userHeaders = "From: support@coffeeandcoding.com\r\n"
             . "Reply-To: support@coffeeandcoding.com\r\n";
@mail($userTo, $userSubject, $userBody, $userHeaders);

// 3) Yöneticiye bildirim e-postası gönder
$adminTo      = 'admin@coffeeandcoding.com';
$adminSubject = 'New support request received';
$adminBody    = "New support request details:\n\n"
              . "Name: {$entry['first_name']} {$entry['last_name']}\n"
              . "Email: {$entry['email']}\n"
              . "Phone: {$entry['phone']}\n"
              . "Preferred date: {$entry['preferred_date']}\n"
              . "Topic: {$entry['topic']}\n"
              . "Message:\n{$entry['message']}\n"
              . "Attachment: " . ($entry['file'] ?? '—') . "\n\n"   // ▲ ek dosya bilgisi
              . "Submitted at: {$entry['submitted_at']}";
$adminHeaders = "From: no-reply@coffeeandcoding.com\r\n";
@mail($adminTo, $adminSubject, $adminBody, $adminHeaders);

// 4) AJAX’a basit OK yanıtı dön
header('Content-Type: text/plain; charset=utf-8');
echo 'OK';
