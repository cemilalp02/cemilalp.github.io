<?php
$topics=json_decode(file_get_contents(__DIR__.'/forum_topics.json'),true);
$cats=array_count_values(array_map(fn($t)=>$t['category'],$topics));
arsort($cats); $topCat=key($cats);
$topTopic=$topics[0]; foreach($topics as $t){if($t['likes']>$topTopic['likes'])$topTopic=$t;}
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><title>Forum Stats</title><link rel="stylesheet" href="style.css"></head><body>
<nav class="navbar"><div class="container nav-content"><a href="index.php" class="logo">Coffee &amp; Coding</a></div></nav>
<div class="container" style="max-width:600px;margin-top:2rem;"><h1>Forum Statistics</h1><ul><li>Total topics: <?= count($topics) ?></li><li>Most active category: <?= htmlspecialchars($topCat) ?></li><li>Most liked topic: "<?= htmlspecialchars($topTopic['title']) ?>" with <?= $topTopic['likes'] ?> likes</li></ul></div></body></html>
