<?php
session_start();
$user = $_SESSION['user']['name'] ?? null;

/* --- SORU–CEVAP VERİSİ --- */
$qFile = __DIR__ . '/questions.json';
$faq   = file_exists($qFile) ? json_decode(file_get_contents($qFile), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee &amp; Coding - FAQ</title>

  <!-- jQuery-UI CSS -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Global stylesheet -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- ===== NAVBAR ===== -->
<nav class="navbar">
  <div class="container nav-content">
    <a href="index.php" class="logo">Coffee &amp; Coding</a>
    <ul class="nav-links">
      <li><a href="index.php"        <?= basename($_SERVER['PHP_SELF'])==='index.php'      ?'class="active"':'' ?>>Home</a></li>
      <li><a href="projects.php"     <?= basename($_SERVER['PHP_SELF'])==='projects.php'    ?'class="active"':'' ?>>Projects</a></li>
      <li><a href="activities.php"   <?= basename($_SERVER['PHP_SELF'])==='activities.php'  ?'class="active"':'' ?>>Activities</a></li>
      <li><a href="forum.php"        <?= basename($_SERVER['PHP_SELF'])==='forum.php'       ?'class="active"':'' ?>>Forum</a></li>
      <li><a href="faq.php"          <?= basename($_SERVER['PHP_SELF'])==='faq.php'         ?'class="active"':'' ?>>FAQ</a></li>
      <li><a href="support.php"      <?= basename($_SERVER['PHP_SELF'])==='support.php'     ?'class="active"':'' ?>>Support</a></li>
      <li><a href="index.php#about">About Us</a></li>
      <li><a href="index.php#contact">Contact</a></li>

      <?php if ($user): ?>
        <li style="display:flex;align-items:center;gap:.5rem;">
          <span style="color:#fff;">Hi, <?= htmlspecialchars($user) ?>!</span>
          <a href="logout.php" class="btn-login" style="background:#dc3545;">Log out</a>
        </li>
      <?php else: ?>
        <li><a href="signup.html" class="btn-login">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- ===== FAQ CONTENT ===== -->
<main class="container">
  <img src="images/image8.jpg" class="moving-image" alt="Question mark">
  <h1 class="faq-title">Frequently Asked Questions</h1>

  <section id="faq-accordion" class="faq-section">
   <!-- Static questions -->
    <h3>How can I join Coffee & Coding?</h3>
    <div><p>Simply click the Login button to sign up and become part of our community.</p></div>

    <h3>Where can I find tutorials?</h3>
    <div><p>Tutorials are available on the Tutorials page with step-by-step guides and video lessons.</p></div>

    <h3>How do I participate in activities?</h3>
    <div><p>Visit the Activities page to see upcoming events and register.</p></div>

    <h3>Who can I contact for support?</h3>
    <div><p>You can reach out to our support team via the Support page.</p></div>

   <!-- Dynamic questions -->
    <?php foreach ($faq as $q): ?>
      <h3><?= htmlspecialchars($q['question']); ?>
          <small style="font-size:.8rem;"> — <?= htmlspecialchars($q['author']); ?></small></h3>
      <div>
      <?php if ($q['answer']): ?>
        <p><?= nl2br(htmlspecialchars($q['answer'])); ?></p>

        <?php if ($user): ?>
          <button class="btn edit-answer"
                  data-id="<?= $q['id']; ?>"
                  data-answer="<?= htmlspecialchars($q['answer'],ENT_QUOTES) ?>">Edit</button>

          <button class="btn delete-answer"
                  data-id="<?= $q['id']; ?>"
                  onclick="return confirm('Delete ONLY the answer?');">Delete Answer</button>

          <button class="btn delete-question"
                  data-id="<?= $q['id']; ?>"
                  onclick="return confirm('Delete ENTIRE question?');">Delete Question</button>
        <?php endif; ?>

      <?php elseif ($user): ?>
        <button class="btn answer-btn" data-id="<?= $q['id']; ?>">Answer</button>
      <?php else: ?>
        <p><em>No answer yet.</em></p>
      <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </section>

  <!-- Question form -->
  <section class="submit-question">
    <h2>Submit Your Question</h2>

    <?php if ($user): ?>  
      <form id="ask-form">
        <label>Your Question:</label>
        <textarea id="user-question" name="question" required></textarea>
        <button type="submit" class="btn-submit">Submit Question</button>
      </form>
    <?php else: ?>
      <p style="color:#e74c3c;">Please <a href="login.html">log in</a> or
         <a href="signup.html">sign up</a> to submit a question.</p>
    <?php endif; ?>
  </section>
</main>

<!-- Answer Dialog -->
<div id="answer-dialog" title="Answer Question" style="display:none;">
  <form id="answer-form">
    <input type="hidden" name="id">
    <label>Answer:</label>
    <textarea name="answer" required></textarea>
    <button type="submit" class="btn-submit">Save</button>
  </form>
</div>

<footer class="footer">
  <div class="container footer-content">
    <p>&copy; 2025 Coffee &amp; Coding | All Rights Reserved</p>
    <div class="social-links">
      <a href="https://github.com/cemilalp02" target="_blank">
        <img src="images/github_2504911.png" alt="GitHub" class="social-icon">
      </a>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function () {
  $('#faq-accordion').accordion({heightStyle:'content', collapsible:true, active:false});
/* ── Add question ── */
  $('#ask-form').on('submit', e=>{
    e.preventDefault();
    $.post('submit_question.php', $(e.target).serialize(), ()=>location.reload());
  });

  /* ── New answer ── */
  $(document).on('click','.answer-btn', function(){
    $('#answer-form')[0].reset();
    $('#answer-form [name=id]').val($(this).data('id'));
    $('#answer-dialog').dialog({modal:true,width:500});
  });

/* ── Edit answer ── */
  $(document).on('click','.edit-answer', function(){
    $('#answer-form [name=id]').val($(this).data('id'));
    $('#answer-form [name=answer]').val($(this).data('answer'));
    $('#answer-dialog').dialog({modal:true,width:500});
  });

  /* ── Delete Answer ── */
  $(document).on('click','.delete-answer', function(){
    $.post('delete_answer.php', {id: $(this).data('id')}, ()=>location.reload());
  });

  /* ── Delete Question ── */
  $(document).on('click','.delete-question', function(){
    $.post('delete_question.php', {id: $(this).data('id')}, ()=>location.reload());
  });

 /* ── Save (new / update) ── */
  $('#answer-form').on('submit', e=>{
    e.preventDefault();
    $.post('answer_question.php', $(e.target).serialize(), ()=>location.reload());
  });
});
</script>
</body>
</html>
