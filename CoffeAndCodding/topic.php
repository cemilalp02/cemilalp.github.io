<?php
// topic.php – styled topic detail page
session_start();
$id   = $_GET['id'] ?? '';
$tFile = __DIR__ . '/forum_topics.json';
$rFile = __DIR__ . '/forum_replies.json';
$topics = file_exists($tFile) ? json_decode(file_get_contents($tFile), true) : [];
$topic = null;
foreach ($topics as $t) if ($t['id'] === $id) $topic = $t;
if (!$topic) { echo 'Topic not found'; exit; }
$replies = file_exists($rFile) ? json_decode(file_get_contents($rFile), true) : [];
$likes   = $topic['likes'] ?? 0;
$liked   = isset($_SESSION['liked']) && in_array($id, $_SESSION['liked'] ?? [], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($topic['title']) ?> – Coffee & Coding Forum</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <style>
    /* Page‑specific tweaks */
    .topic-detail { max-width: 900px; margin: 3rem auto; background:#fff; padding:2rem 2.5rem; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,.1); }
    .topic-meta { color:#777; font-size:0.9rem; margin-bottom:1rem; }
    .like-btn { background:none; border:1px solid #c39758; color:#c39758; padding:0.35rem 0.75rem; border-radius:20px; font-size:0.9rem; cursor:pointer; transition:.3s; display:inline-flex; align-items:center; gap:4px; }
    .like-btn.liked, .like-btn:hover { background:#c39758; color:#fff; }
    .replies { margin-top:2.5rem; }
    .reply-card { background:#f8f8f8; border-radius:8px; padding:1rem 1.25rem; box-shadow:0 2px 6px rgba(0,0,0,.06); margin-bottom:1rem; }
    .reply-header { font-size:0.85rem; color:#555; margin-bottom:0.5rem; }
    .reply-form textarea { width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:6px; font-family:inherit; resize:vertical; }
    .btn-send { background:#007bff; color:#fff; border:none; padding:0.6rem 1.25rem; border-radius:6px; font-weight:500; margin-top:0.6rem; cursor:pointer; transition:.3s; }
    .btn-send:hover { background:#0056b3; }
  </style>
  <script>
  $(function(){
    $('#likeBtn').on('click', function(){
      $.post('like_topic.php',{id:'<?= $id ?>'}, function(r){
        $('#likeCount').text(r.likes);
        $('#likeBtn').toggleClass('liked', r.liked);
      },'json');
    });

    $('#replyForm').on('submit', function(e){
      e.preventDefault();
      $.post('reply_submit.php', $(this).serialize())
        .done(()=>{ toastr.success('Reply added'); location.reload(); })
        .fail(()=> toastr.error('Failed to add reply') );
    });
  });
  </script>
</head>
<body>
  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="container nav-content">
      <a href="index.php" class="logo">Coffee &amp; Coding</a>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="activities.php">Activities</a></li>
        <li><a href="forum.php" class="active">Forum</a></li>
        <li><a href="faq.php">FAQ</a></li>
        <li><a href="support.php">Support</a></li>
      </ul>
    </div>
  </nav>

  <main class="topic-detail">
    <h1><?= htmlspecialchars($topic['title']) ?></h1>
    <p class="topic-meta">by <strong><?= htmlspecialchars($topic['author']) ?></strong> on <?= date('F d, Y H:i', strtotime($topic['timestamp'])) ?> ·
       <span id="likeCount"><?= $likes ?></span> likes
       <button id="likeBtn" class="like-btn <?= $liked ? 'liked' : '' ?>">+1</button>
    </p>

    <section class="replies">
      <h2>Replies</h2>
      <?php foreach ($replies as $r): if ($r['topic']===$id): ?>
        <div class="reply-card">
          <div class="reply-header"><strong><?= htmlspecialchars($r['author']) ?></strong> · <?= date('M d, H:i', strtotime($r['ts'])) ?></div>
          <div><?= nl2br($r['message']) ?></div>
        </div>
      <?php endif; endforeach; ?>

      <?php if (isset($_SESSION['user'])): ?>
        <h3>Write a reply</h3>
        <form id="replyForm" class="reply-form">
          <textarea name="msg" rows="4" required></textarea>
          <input type="hidden" name="topic" value="<?= $id ?>">
          <button type="submit" class="btn-send">Send</button>
        </form>
      <?php else: ?>
        <p><a href="login.html">Log in</a> to reply.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>