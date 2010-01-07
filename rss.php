<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();



$engine->localVars('pageTitle',"WVU Libraries: Databases");


if (isset($_GET['type'])) {
	$localVars['exclude_template'] = TRUE;
	header('Content-type: application/xml');
}
else {
	$engine->eTemplate("load","1col");
}

recurseInsert("dbTables.php","php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

// Fire up the Engine
$engine->eTemplate("include","header");

recurseInsert("buildLists.php","php");
?>
<?php
if(empty($_GET)) {
?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>WVU Libraries Database RSS Feeds</h3>

<a href="rss.php?type=newdb">New Databases</a>
<br />
<a href="rss.php?type=news">Database News and Announcements</a>
<br />
<a href="rss.php?type=combined">Combined</a>

</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<?php } ?>
<?php

if (!empty($cleanGet)) {

	$rss                = new rss();
	$rss->title         = "WVU Libraries Databases: ";
	$rss->link          = "http://www.libraries.wvu.edu/databases/";
	$rss->lastBuildDate = gmdate("D, j M Y G:i:s T");
	

	if($engine->cleanGet['HTML']['type'] == "newdb") {
		
		$rss->title .= "New and Trial Databases";
		$rss->description = "WVU Libraries New and Trial databases.";
	
		$sql = "SELECT * FROM dbList WHERE newDatabase='1' OR trialDatabase='1' ORDER BY createDate DESC LIMIT 10";
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {
			
			$dbURL = $engineVars['WVULSERVER']."/databases/database.php?id=".$row['ID'];
			
			$dbDesc = "";
			$dbDesc .= ($row['newDatabase'] == 1)?"<img src=\"".$engineVars['WVULSERVER']."/databases/images/new.gif\" />&nbsp;":"";
			$dbDesc .= ($row['trialDatabase'] == 1)?"<img src=\"".$engineVars['WVULSERVER']."/databases/images/trial.gif\" />&nbsp;":"";
			$dbDesc .= $row['description'];
			
			$rss->addItem($row['name'],$dbURL,$dbURL,gmdate("D, j M Y G:i:s T",$row['createDate']),$dbDesc);
		}
		
		
		$xml = $rss->buildRSS();
	}
	else if ($engine->cleanGet['HTML']['type'] == "news") {
		$rss->title .= "News and Announcements";
		$rss->description = "WVU Libraries Database News and Announcements.";
		
		$sql = "SELECT * FROM news ORDER BY ID DESC LIMIT 10";
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {
			
			$dbURL = $engineVars['WVULSERVER']."/databases/database.php?id=".$row['ID'];
			
			$dbDesc = "";
			
			$rss->addItem($row['name'],$dbURL,$dbURL,gmdate("D, j M Y G:i:s T"),$dbDesc);
		}
		
		$xml = $rss->buildRSS();
		
	}
	else if ($engine->cleanGet['HTML']['type'] == "combined") {
		$rss->title .= "Combined RSS Feed.";
		$rss->description = "WVU Libraries Database combined RSS feed. News and Announcements, New Databases, Trial Databases.";
		
		$sql = "SELECT * FROM dbList WHERE newDatabase='1' OR trialDatabase='1' ORDER BY createDate DESC LIMIT 10";
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {
			
			$dbURL = $engineVars['WVULSERVER']."/databases/database.php?id=".$row['ID'];
			
			$dbDesc = "";
			$dbDesc .= ($row['newDatabase'] == 1)?"<img src=\"".$engineVars['WVULSERVER']."/databases/images/new.gif\" />&nbsp;":"";
			$dbDesc .= ($row['trialDatabase'] == 1)?"<img src=\"".$engineVars['WVULSERVER']."/databases/images/trial.gif\" />&nbsp;":"";
			$dbDesc .= $row['description'];
			
			$rss->addItem($row['name'],$dbURL,$dbURL,gmdate("D, j M Y G:i:s T",$row['createDate']),$dbDesc);
		}
		
		$sql = "SELECT * FROM news ORDER BY ID DESC LIMIT 10";
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {
			
			$dbURL = $engineVars['WVULSERVER']."/databases/database.php?id=".$row['ID'];
			
			$dbDesc = "";
			
			$rss->addItem($row['name'],$dbURL,$dbURL,gmdate("D, j M Y G:i:s T"),$dbDesc);
		}
		
		$xml = $rss->buildRSS();
		
	}

print $xml;

}

?>
<?php
$engine->eTemplate("include","footer");
?>