<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

$engine->localVars('pageTitle',"Database Management: Vendors");

recurseInsert("dbTables.php","php");
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engine->dbConnect("database","databases",TRUE);

recurseInsert("acl.php","php");
$engine->accessControl("build");

$engine->eTemplate("include","header");
?>

<?php
$dbTables = $engine->dbTablesExport();

$engine->localVars('listAddLabel', "Vendors");
$engine->localVars('listAddTable', $dbTables["vendors"]["prod"]);

$localVars = $engine->localVarsExport();

$cols = array();
$cols[1]["table"] = "name";
$cols[1]["label"] = "Vendor";

$cols[2]["table"] = "url";
$cols[2]["label"] = "URL";

?>


<!-- Page Content Goes Below This Line -->

<h2>{local var="pageTitle"}</h2>

<?php
//Submit the form

if(isset($engine->cleanPost['MYSQL']['newSubmit'])) {
	
	$output = webHelper_listMultiInsert($localVars['listAddTable'],$localVars['listAddLabel'],$cols,$engine);

	echo $output;

}
else if (isset($engine->cleanPost['MYSQL']['updateSubmit'])) {
	$output = webhelper_listMultiUpdate($localVars['listAddTable'],$cols,$engine);
	
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

{engine name="function" function="webHelper_listMultiEditList" table="{local var="listAddTable"}" cols="2" col1="<?php print $cols[1]["table"]; ?>" col2="<?php print $cols[2]["table"]; ?>" col1label="<?php print $cols[1]["label"]; ?>" col2label="<?php print $cols[2]["label"]; ?>"}

<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>