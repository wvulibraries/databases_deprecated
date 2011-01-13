<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine2.0";
include($engineDir ."/engine.php");
$engine = new EngineCMS();



$engine->localVars('pageTitle',"WVU Libraries: Databases");
$engine->eTemplate("load","1col");

recurseInsert("dbTables.php","php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

// Fire up the Engine
$engine->eTemplate("include","header");
?>

<?php
include("buildStatus.php");

switch($engine->cleanGet['HTML']['type']) {
	case "new":
	$pageHeader = "New";
	$searchType = "newDatabase";
	break;
	case "trial":
	$pageHeader = "Trial";
	$searchType = "trialDatabase";
	break;
	case "full":
	$pageHeader = "Full Text";
	$searchType = "fullTextDB";
	break;
	default:
	$pageHeader = "Error (Defaulting to Full Text)";
	$searchType = "fullTextDB";
}

?>

<?php

recurseInsert("buildLists.php","php");

?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3><?php print (!empty($pageHeader))?$pageHeader:"Error"; ?> Databases</h3>


<?php

$sql = "select * from dbList WHERE ".$searchType."='1' AND (".$status.") ORDER BY name";
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
}
?>

<?php
	include("buildDBListing.php");
?>

</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>