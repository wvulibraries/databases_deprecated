<?php

global $engine;

$currentStatus = (empty($engine->cleanGet['HTML']['status']))?"":"status=".$engine->cleanGet['HTML']['status'];

localvars::add("currentStatus",$currentStatus);

localvars::add("popular",buildPopularDB());
localvars::add("letters",buildTitleLetter());
localvars::add("resourceTypes",buildResourceTypes());
localvars::add("news",buildNews());

?>

<br /><a href="/services/ask/database/" title="Help Accessing Databases">Help Accessing Databases</a><br />

{local var="popular"}

<ul>

<li class="rightNavListHeader">Databases By Subject</li>

<li><a href="/databases/index.php?{local var="currentStatus"}" id="rightNavSubLink">Subjects</a></li>
<li class="noBorder"></li>
<li class="noBorder"></li>
<li><a href="/databases/newdatabases.php?type=full&amp;{local var="currentStatus"}" id="rightNavSubLink">Full Text</a></li>
<li><a href="/databases/newdatabases.php?type=alumni&amp;{local var="currentStatus"}" id="rightNavSubLink">Alumni Databases</a></li>
<li><a href="/databases/newdatabases.php?type=new&amp;{local var="currentStatus"}" id="rightNavSubLink">New Databases</a></li>
<li><a href="/databases/newdatabases.php?type=trial&amp;{local var="currentStatus"}" id="rightNavSubLink">Trial Databases</a></li>
</ul>

{local var="letters"}


{local var="resourceTypes"}

{local var="news"}

<br /><br />
<a href="/databases/rss.php" id="rssIcon"><img src="/databases/images/rss.gif" /></a>