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
?>

<?php

recurseInsert("buildLists.php","php");

$sql = "SELECT * FROM resourceTypes WHERE ID=".$cleanGet['MYSQL']['id'];
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
}
else {
	$rtInfo = mysql_fetch_array($sqlResult['result'], MYSQL_NUM);
}
?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3><?php print (!empty($rtInfo[1]))?$rtInfo[1]:"SQL Error"; ?> Databases</h3>

<?php

$sql = "select * from dbList JOIN databases_resourceTypes where databases_resourceTypes.resourceID='".$cleanGet['MYSQL']['id']."' AND dbList.ID=databases_resourceTypes.dbID AND (".$status.") ORDER BY dbList.name";
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