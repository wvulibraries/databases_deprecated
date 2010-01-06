<?php

global $cleanGet;

$currentStatus = (empty($cleanGet['HTML']['status']))?"":"status=".$cleanGet['HTML']['status'];

$popular  = buildPopularDB();
$letters  = buildTitleLetter();
$resourceTypes = buildResourceTypes();
$news = buildNews();

?>

<h4>Popular Databases</h4>

<?= $popular ?>

<h4>Databases By Subject</h4>

<a href="/databases/index.php?<?= $currentStatus ?>" id="rightNavSubLink">Subjects</a>
<br /><br />
<a href="/databases/newdatabases.php?type=full&amp;<?= $currentStatus ?>" id="rightNavSubLink">Full Text</a>
<br />
<a href="/databases/newdatabases.php?type=new&amp;<?= $currentStatus ?>" id="rightNavSubLink">New Databases</a>
<br />
<a href="/databases/newdatabases.php?type=trial&amp;<?= $currentStatus ?>" id="rightNavSubLink">Trial Databases</a>


<h4>Databases By Title</h4>
<?= $letters ?>

<h4>Databases by Resource Type</h4>
<?= $resourceTypes ?>

<h4>News</h4>
<?= $news ?>

<br /><br />
<a href="/databases/rss.php" id="rssIcon"><img src="/databases/images/rss.gif" /></a>