<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

$localVars = array(); //Do not delete this line

$localVars['pageTitle']       = "Database Managemet: Subjects";

$accessControl = array(); //Do not delete this line

$accessControl['AD']['Groups']['webDatabaseAdmin'] = 1;

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<?php
global $dbTables;

$localVars['listAddLabel'] = "Subjects";
$localVars['listAddTable'] = $dbTables["subjects"]["prod"];

$cols = array();
$cols[1]["table"] = "name";
$cols[1]["label"] = "Subject";

$cols[2]["table"] = "url";
$cols[2]["label"] = "URL";

?>


<!-- Page Content Goes Below This Line -->

<h2>{local var="pageTitle"}</h2>

<?php
//Submit the form

if(isset($cleanPost['MYSQL']['newSubmit'])) {
	
	$output = webHelper_listMultiInsert($localVars['listAddTable'],$localVars['listAddLabel'],$cols);

	echo $output;

}
else if (isset($cleanPost['MYSQL']['updateSubmit'])) {
	$output = webhelper_listMultiUpdate($localVars['listAddTable'],$cols);
	
	echo $output;
}

?>

<h3>{local var="listAddLabel"} Management</h3>

{engine name="function" function="webHelper_listMultiAdd" table="{local var="listAddTable"}" label="{local var="listAddLabel"}" cols="2" <?php 
foreach ($cols as $I=>$col) {
	echo sprintf("col%s=\"%s\" col%slabel=\"%s\" ",$I,$col["table"],$I,$col["label"]);
}
?>}



<hr />

{engine name="function" function="webHelper_listMultiEditList" table="{local var="listAddTable"}" cols="2" col1="<?= $cols[1]["table"] ?>" col2="<?= $cols[2]["table"] ?>" col1label="<?= $cols[1]["label"] ?>" col2label="<?= $cols[2]["label"] ?>"}

<!-- Page Content Goes Above This Line -->

<?php
include($engineDir ."/engineFooter.php");
?>