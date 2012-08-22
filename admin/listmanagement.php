<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = &new EngineCMS();

$engine->localVars('pageTitle',"Database Management: List Management");

recurseInsert("dbTables.php","php");
$engine->dbConnect("database","databases",TRUE);

recurseInsert("acl.php","php");
$engine->accessControl("build");

$engine->eTemplate("include","header");
?>

<?php
//global $cleanGet;
$dbTables = $engine->dbTablesExport();

$engine->localVars('listAddLabel', $engine->cleanGet['MYSQL']['type']);
$engine->localVars('listAddTable', $dbTables[$engine->cleanGet['MYSQL']['type']]["prod"]);

switch ($engine->cleanGet['MYSQL']['type']) {
    case "accessType":
        $engine->localVars('listAddLabel', "Access Type");
        break;
	case "accessPlainText":
	    $engine->localVars('listAddLabel', "Access Plain Text");
	    break;
	case "resourceTypes":
	    $engine->localVars('listAddLabel', "Resource Types");
		break;
	case "updateText":
	    $engine->localVars('listAddLabel', "Update Text");
	    break;
	case "news":
	    $engine->localVars('listAddLabel', "News");
		break;
	default:
	    $engine->localVars('listAddLabel', "Error");
		print "Invalid List Requested.";
		exit;
}

$localVars = $engine->localVarsExport();

?>


<!-- Page Content Goes Below This Line -->

<h2>{local var="pageTitle"}</h2>

<?php
//Submit the form

if(isset($engine->cleanPost['MYSQL']['newSubmit'])) {
	
	$output = webHelper_listInsert($localVars['listAddTable'],$localVars['listAddLabel'],$engine);

	echo $output;

}
else if (isset($engine->cleanPost['MYSQL']['updateSubmit'])) {
	$output = webhelper_listUpdate($localVars['listAddTable'],$engine);
	
	echo $output;
}

?>

<h3>{local var="listAddLabel"} Management</h3>

{engine name="function" function="webHelper_listAdd" table="{local var="listAddTable"}" label="{local var="listAddLabel"}" addget="true"}

<hr />

{engine name="function" function="webHelper_listEditList" table="{local var="listAddTable"}" addget="true"}

<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>