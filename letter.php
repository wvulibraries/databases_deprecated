<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
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

$pageHeader = (!empty($engine->cleanGet['HTML']['id']))?$engine->cleanGet['HTML']['id']:"";

if($engine->cleanGet['HTML']['id'] == "num") {
	$engine->cleanGet['HTML']['id'] = "1' OR name REGEXP '^2' OR name REGEXP '^3' OR name REGEXP '^4' OR name REGEXP '^5' OR name REGEXP '^6' OR name REGEXP '^7' OR name REGEXP '^8' OR name REGEXP '^9' OR name REGEXP '^0";
}

if ($pageHeader == "num") {
	$pageHeader = "Number";
}

?>

<?php

recurseInsert("buildLists.php","php");

?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>Databases by Title: <?php print (!empty($pageHeader))?$pageHeader:"Error"; ?> </h3>


<?php

$sql = "select * from dbList WHERE (name REGEXP '^".$engine->cleanGet['HTML']['id']."') AND (".$status.") ORDER BY name";
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