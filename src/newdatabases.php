<?php

require_once("/home/library/public_html/includes/engineHeader.php");

$engine->localVars('pageTitle',"WVU Libraries: Databases");

// $engine->eTemplate("load","library2012.2col.right");
$engine->eTemplate("load","library2014-backpage");

recurseInsert("dbTables.php","php");
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
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
	case "alumni":
	$pageHeader = "Alumni";
	$searchType = "alumni";
	break;
	case "mobile":
	$pageHeader = "Mobile";
	$searchType = "mobile";
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
	// print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
	print webHelper_errorMsg("Error Retrieving database");
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