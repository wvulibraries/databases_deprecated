<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

$localVars = array(); //Do not delete this line

$localVars['pageTitle']      = "WVU Libraries: Databases";
$localVars['engineTemplate'] = "1col";

$accessControl = array(); //Do not delete this line

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<?php
include("buildStatus.php");

switch($cleanGet['HTML']['type']) {
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
include($engineDir ."/engineFooter.php");
?>