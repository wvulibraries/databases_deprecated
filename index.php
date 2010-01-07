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

// Check for and expire trial databases
$sql = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<".time();
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);
//

$localVars['status'] = 1;
if(!empty($engine->cleanGet['HTML']['status'])) {
	$localVars['status'] = $engine->cleanGet['HTML']['status'];
}

?>

<?php

recurseInsert("buildLists.php","php");
$subjects = buildSubjectList();

?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>Databases by Subject</h3>

<?= $subjects ?>

</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script>

<?php
$engine->eTemplate("include","footer");
?>