<?php

require_once("/home/library/public_html/includes/engineHeader.php");

$engine->localVars('pageTitle',"WVU Libraries: Databases");

$engine->eTemplate("load","library2012.2col.right");

recurseInsert("dbTables.php","php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

// Fire up the Engine
$engine->eTemplate("include","header");
?>

<?php
include("buildStatus.php");
?>

<?php

recurseInsert("buildLists.php","php");

$badError = FALSE;
if (!isint($engine->cleanGet['MYSQL']['id'])) {
	print webHelper_errorMsg("Invalid Resource Type Provided");
	$badError = TRUE;
}
else {

	$sql = sprintf("SELECT * FROM resourceTypes WHERE ID='%s'",
		$engine->cleanGet['MYSQL']['id']
		);
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);

	if (!$sqlResult['result']) {
		// print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
		print webHelper_errorMsg("Error Retrieving database");
	}
	else {
		$rtInfo = mysql_fetch_array($sqlResult['result'], MYSQL_NUM);
	}
}
?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<?php if ($badError === FALSE) { ?>

<h3><?php print (!empty($rtInfo[1]))?$rtInfo[1]:"Invalid Resource Type"; ?> Databases</h3>

<?php

$sql = "select * from dbList JOIN databases_resourceTypes where databases_resourceTypes.resourceID='".$engine->cleanGet['MYSQL']['id']."' AND dbList.ID=databases_resourceTypes.dbID AND (".$status.") ORDER BY dbList.name";
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
}
?>

<?php
	include("buildDBListing.php");
?>

<?php }?>

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