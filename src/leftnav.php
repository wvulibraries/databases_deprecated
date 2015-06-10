<?php

$localvars = localvars::getInstance();
$localvars->set("currentStatus",status::build());

$dbObject = new databases;

$popularDatabases = $dbObject->getByType("popular");
$localvars->set("popular",lists::popular($popularDatabases));

// $localvars->set("letters",buildTitleLetter());
// $localvars->set("resourceTypes",buildResourceTypes());
// $localvars->set("news",buildNews());

?>
<ul>
    <li><a href="/services/ask/database/" title="Help Accessing Databases">Help Accessing Databases</a></li>
</ul>

<span class="rightNavListHeader">Popular Databases</span>
{local var="popular"}

<span class="rightNavListHeader">Databases By Subject</span>
<ul>
<li><a href="/databases/?{local var="currentStatus"}" id="rightNavSubLink">Subjects</a></li>
<li class="noBorder"></li>
<li class="noBorder"></li>
<li><a href="/databases/type/?type=full&amp;{local var="currentStatus"}" id="rightNavSubLink">Full Text</a></li>
<li><a href="/databases/type/?type=alumni&amp;{local var="currentStatus"}" id="rightNavSubLink">Alumni Databases</a></li>
<li><a href="/databases/type/?type=mobile&amp;{local var="currentStatus"}" id="rightNavSubLink">Mobile Databases</a></li>
<li><a href="/databases/type/?type=new&amp;{local var="currentStatus"}" id="rightNavSubLink">New Databases</a></li>
<li><a href="/databases/type/?type=trial&amp;{local var="currentStatus"}" id="rightNavSubLink">Trial Databases</a></li>
</ul>

{local var="letters"}


{local var="resourceTypes"}

{local var="news"}

<ul>
    <li><a href="/databases/rss.php" id="rssIcon"><img src="/databases/images/rss.gif" /></a></li>
</ul>