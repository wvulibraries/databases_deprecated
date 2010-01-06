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

// Check for and expire trial databases
$sql = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<".time();
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);
//

$localVars['status'] = 1;
if(!empty($cleanGet['HTML']['status'])) {
	$localVars['status'] = $cleanGet['HTML']['status'];
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
include($engineDir ."/engineFooter.php");
?>