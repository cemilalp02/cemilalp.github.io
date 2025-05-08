<?php
session_start();
$file = __DIR__ . '/forum_topics.json';
$topics = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

function filterTopics($topics, $search) {
  if (!$search) return $topics;
  $search = strtolower($search);
  return array_filter(
    $topics,
    fn($t) => str_contains(strtolower($t['title']), $search) ||
              str_contains(strtolower($t['category']), $search)
  );
}

$searchQuery    = $_GET['search'] ?? '';
$filteredTopics = filterTopics($topics, $searchQuery);

/* ---------- İstatistikler ---------- */
$total      = count($topics);
$topCatMap  = array_count_values(array_column($topics, 'category'));
$topCatName = $topCatMap ? array_keys($topCatMap, max($topCatMap))[0] : '—';
$topLiked   = $topics ? max(array_map(fn($t)=>$t['likes'] ?? 0, $topics)) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Community Forum – Coffee & Coding</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script>
  $(function () {
    const categories = ['JavaScript','HTML','CSS','jQuery','Python','C++','Algorithms'];
    $('#topic-category').autocomplete({ source: categories });

    $('#dialog-new-topic').dialog({ autoOpen:false, modal:true, width:500 });
    $('.new-topic').on('click', () => $('#dialog-new-topic').dialog('open'));

    $('#new-topic-form').on('submit', function (e) {
      e.preventDefault();
      $.post('forum_submit.php', $(this).serialize())
        .done(()=>location.reload())
        .fail(()=>alert('Error submitting topic.'));
    });
  });
  </script>
  <style>
    /* ===== Forum Background ===== */
    body::before{
      content:"";
      position:fixed;inset:0;z-index:-1;
      background:url("images/forum_bg.jpg") center/cover no-repeat fixed,
                linear-gradient(135deg,#f3e9d2 0%,#d2baa1 100%);
      background-blend-mode: multiply;
      opacity:.18;
    }

    .forum-container{padding:2rem;max-width:1000px;margin:auto}
    .topic-card{background:#fff;border-radius:8px;padding:1rem;margin-bottom:1rem;box-shadow:0 2px 6px rgba(0,0,0,.1)}
    .topic-meta{font-size:.9rem;color:#777;margin-bottom:.5rem}
    .topic-title{font-size:1.2rem;font-weight:600;color:#333;margin:0}
    .topic-category{background:#007bff;color:#fff;padding:.2rem .5rem;border-radius:4px;font-size:.8rem;margin-left:.5rem}
    .btn{background:#28a745;color:#fff;padding:.5rem 1rem;border:none;border-radius:4px;cursor:pointer}
    .btn:hover{background:#218838}
    .search-bar{margin-bottom:1rem;display:flex;gap:.5rem}
    .search-bar input{flex:1;padding:.5rem;border:1px solid #ccc;border-radius:4px}
    .stats{background:rgba(255,255,255,.8);backdrop-filter:blur(4px);padding:.6rem 1rem;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.08);text-align:center;margin-bottom:1rem;font-weight:500}
  </style>
</head>
<body>
  <!-- Navbar -->
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

  <div class="forum-container">
    <div class="forum-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
      <h1>Community Forum</h1>
      <?php if(isset($_SESSION['user'])): ?>
        <button class="btn new-topic">+ New Topic</button>
      <?php else: ?>
        <a href="login.html" class="btn">Log In to Post</a>
      <?php endif; ?>
    </div>

    <!-- Search -->
    <form method="GET" class="search-bar">
      <input type="text" name="search" placeholder="Search topics..." value="<?=htmlspecialchars($searchQuery)?>">
      <button class="btn">Search</button>
    </form>

    <!-- Statistics box -->
    <div class="stats">
      <span>Total topics: <?=$total?></span> ·
      <span>Most popular category: <?=htmlspecialchars($topCatName)?></span> ·
      <span>Highest likes: <?=$topLiked?></span>
    </div>

    <!-- Topics -->
    <div class="forum-topics">
      <?php if(empty($filteredTopics)): ?>
        <p>No topics found. Try a different search or add a new one!</p>
      <?php else: ?>
        <?php usort($filteredTopics, fn($a,$b)=>(int)($b['pinned']??0)<=>($a['pinned']??0)); ?>
        <?php foreach (array_reverse($filteredTopics) as $topic): ?>
          <div class="topic-card">
            <p class="topic-meta">
              Posted by <strong><?=htmlspecialchars($topic['author'])?></strong>
              on <?=date('M d, Y H:i', strtotime($topic['timestamp']))?> ·
              <span><?=($topic['likes']??0)?> likes</span>
              <?php if(($topic['pinned']??false)): ?><span style="color:#e67e22"> · pinned</span><?php endif; ?>
            </p>
            <h2 class="topic-title">
              <a href="topic.php?id=<?=$topic['id']?>" style="text-decoration:none;color:inherit;">
                <?=htmlspecialchars($topic['title'])?>
              </a>
              <span class="topic-category">#<?=htmlspecialchars($topic['category'])?></span>
            </h2>
            <p style="margin-top:.5rem;color:#444;">Click to read or reply.</p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- New Topic Dialog -->
  <div id="dialog-new-topic" title="Start a New Discussion" style="display:none;">
    <form id="new-topic-form">
      <div class="form-group">
        <label for="topic-title">Title</label>
        <input type="text" name="title" id="topic-title" required style="width:100%;padding:.5rem;">
      </div>
      <div class="form-group" style="margin-top:1rem;">
        <label for="topic-category">Category</label>
        <input type="text" name="category" id="topic-category" required style="width:100%;padding:.5rem;">
      </div>
      <div style="text-align:right;margin-top:1.5rem;">
        <button type="submit" class="btn">Post Topic</button>
      </div>
    </form>
  </div>
</body>
</html>