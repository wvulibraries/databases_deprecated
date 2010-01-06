<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

$localVars = array(); //Do not delete this line

$localVars['pageTitle']       = "Database Managemet";

$accessControl = array(); //Do not delete this line

$accessControl['AD']['Groups']['webDatabaseAdmin'] = 1;

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<?php
//global $cleanGet;
global $dbTables;

$localVars['listAddLabel'] = $cleanGet['MYSQL']['type'];
$localVars['listAddTable'] = $dbTables[$cleanGet['MYSQL']['type']]["prod"];

switch ($cleanGet['MYSQL']['type']) {
    case "accessType":
        $localVars['listAddLabel'] = "Access Type";
        break;
	case "accessPlainText":
	    $localVars['listAddLabel'] = "Access Plain Text";
	    break;
	case "resourceTypes":
	    $localVars['listAddLabel'] = "Resource Types";
		break;
	case "updateText":
	    $localVars['listAddLabel'] = "Update Text";
	    break;
	case "news":
	    $localVars['listAddLabel'] = "News";
		break;
	default:
	    $localVars['listAddLabel'] = "Error";
}

?>


<!-- Page Content Goes Below This Line -->

<h2>{local var="pageTitle"}</h2>

<?php
//Submit the form

if(isset($cleanPost['MYSQL']['newSubmit'])) {
	
	$output = webHelper_listInsert($localVars['listAddTable'],$localVars['listAddLabel']);

	echo $output;

}
else if (isset($cleanPost['MYSQL']['updateSubmit'])) {
	$output = webhelper_listUpdate($localVars['listAddTable']);
	
	echo $output;
}

?>

<h3>{local var="listAddLabel"} Management</h3>

{engine name="function" function="webHelper_listAdd" table="{local var="listAddTable"}" label="{local var="listAddLabel"}" addget="true"}

<hr />

{engine name="function" function="webHelper_listEditList" table="{local var="listAddTable"}" addget="true"}

<!-- Page Content Goes Above This Line -->

<?php
include($engineDir ."/engineFooter.php");
?>