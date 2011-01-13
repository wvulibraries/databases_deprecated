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
?>

<?php

recurseInsert("buildLists.php","php");

$sql = "SELECT * FROM subjects WHERE ID=".$engine->cleanGet['MYSQL']['id'];
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
}
else {
	$subjectInfo = mysql_fetch_array($sqlResult['result'], MYSQL_NUM);
}
?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3><?php print (!empty($subjectInfo[1]))?$subjectInfo[1]:"SQL Error"; ?> Databases</h3>

<?php if(!empty($subjectInfo[2])) { ?>
	<p id="subjectGuideLink">For a subject guide on this topic:<br />
	<a href="<?= $subjectInfo[2]?>"><?= $subjectInfo[2]?></a>
	</p>
<?php }?>

<?php

$sql = "select * from dbList JOIN databases_subjects where databases_subjects.subjectID='".$engine->cleanGet['MYSQL']['id']."' AND dbList.ID=databases_subjects.dbID AND (".$status.") ORDER BY dbList.name";
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