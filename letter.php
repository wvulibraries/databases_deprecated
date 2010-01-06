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

$pageHeader = (!empty($cleanGet['HTML']['id']))?$cleanGet['HTML']['id']:"";

if($cleanGet['HTML']['id'] == "num") {
	$cleanGet['HTML']['id'] = "1' OR name REGEXP '^2' OR name REGEXP '^3' OR name REGEXP '^4' OR name REGEXP '^5' OR name REGEXP '^6' OR name REGEXP '^7' OR name REGEXP '^8' OR name REGEXP '^9' OR name REGEXP '^0";
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

$sql = "select * from dbList WHERE (name REGEXP '^".$cleanGet['HTML']['id']."') AND (".$status.") ORDER BY name";
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