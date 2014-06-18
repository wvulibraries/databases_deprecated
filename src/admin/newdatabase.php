<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

$engine->localVars('pageTitle',"Database Management");

recurseInsert("dbTables.php","php");
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engine->dbConnect("database","databases",TRUE);
$dbTables = $engine->dbTablesExport();

recurseInsert("acl.php","php");
$engine->accessControl("build");

$engine->eTemplate("include","header");

if (isset($engine->cleanGet['HTML']['id']) && !isint($engine->cleanGet['HTML']['id'])) {
	print "Invalid Database requested";
	exit;
}

?>

<!-- Page Content Goes Below This Line -->

<?php

recurseInsert("buildDBArray.php","php");

if(isset($engine->cleanPost['MYSQL']['deleteDB'])) {

	recurseInsert("deletedb.php","php");
	
	header('Location:/databases/admin/list.php');

}

$engine->localVars('dbID', "null.");
if(!empty($engine->cleanGet['HTML']['id'])) {
	$engine->localVars('dbID', $engine->cleanGet['HTML']['id']);
	
	$sql = sprintf("SELECT * FROM dbList WHERE ID='%s'",
		$engine->openDB->escape($engine->cleanGet['HTML']['id'])
		);
	$engine->openDB->sanitize = FALSE;
	$sqlResult = $engine->openDB->query($sql);
	
	$row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM);
	
	// print "<pre>";
	// var_dump($row);
	// print "</pre>";
	
	buildDBArray($row);
	
	if(!$row[0]) {
		print webHelper_errorMsg("Database ID not Found.");
		$engine->eTemplate("include","footer");
		die;
	}
	
}

$localVars = $engine->localVarsExport();

if(isset($engine->cleanPost['MYSQL']['submitDB'])) {

	recurseInsert("submitdb.php","php");
	$localVars = $engine->localVarsExport();

}
?>

<?php

// print "-= ".$localVars['dbID']." =-";

switch($localVars['dbID']) {
	case "null.":
    	print "<h2>New Database</h2>";
	    break;
	default:
    	print "<h2>Editing: ".$localVars['dbName']."</h2>";

		print "<p>";
		if (isset($localVars['createDate'])) {
			print "Created on: ".date("M d, Y",$localVars['createDate'])."<br />";
		}
		if (isset($localVars['updateDate'])) {
			print "Updated on: ".date("M d, Y",$localVars['updateDate'])."<br />";
		}
		print "</p>";
		?>
	
		<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return confirmDelete();">
			{engine name="insertCSRF"}
			<input type="hidden" name="id" value="{local var="dbID"}">
			<input type="submit" name="deleteDB" value="Delete Database" />
		</form>
	
<?php
		break;
}
?>

<br />

<form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">

{engine name="insertCSRF"}

<input type="hidden" name="newEntry" value="{local var="dbID"}" />

<table>
	<tr>
		<td class="labelTD">
			<label for="dbStatus">Status</label>
		</td>
		<td>
			{engine name="function" function="webHelper_listSelect" table="dbStatus" col="name" select="{local var="dbStatus"}"}
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="dbName">Database Name:</label>
		</td>
		<td>
			<input type="text" id="dbName" name="dbName" value="{local var="dbName"}" />
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="yearsOfCoverage">Years of Coverage:</label>
		</td>
		<td>
			<input type="text" id="yearsOfCoverage" name="yearsOfCoverage" value="{local var="yearsOfCoverage"}" />
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="vendor">Vendor:</label>
		<td>
			{engine name="function" function="webHelper_listSelect" table="vendors" col="name" select="{local var="vendors"}"}
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="dbURL">Database URL</label>
		</td>
		<td>
			<input type="text" id="dbURL" name="dbURL" value="{local var="dbURL"}" />
		</td>
	</tr>
	<tr>
		<td class="labelTD">
			<label for="dbURL">Database URL (off campus):</label>
		</td>
		<td>
			<input type="text" id="dbURLOffCampus" name="dbURLOffCampus" value="{local var="dbURLOffCampus"}" />
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="updateText">Updated:</label>
		<td>
			{engine name="function" function="webHelper_listSelect" table="updateText" col="name" select="{local var="updateText"}"}
		</td>
	</tr>
	
	<tr>
		<td>
			<input type="checkbox" name="popular" id="popular" value="1" {local var="popular"} />
		</td>
		<td class="labelTD">
			<label for="popular">Popular Database</label>
		</td>
	</tr>
	<tr>
		<td class="labelTD">
			<input type="checkbox" name="fullTextDB" id="fullTextDB" value="1" {local var="fullTextDB"} />
		</td>
		<td>
			<label for="fullTextDB">Full Text Database</label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" name="newDB" id="newDB" value="1" {local var="newDB"} />
		</td>
		<td class="labelTD">
			<label for="newDB">New Database</label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" name="trialDB" id="trialDB" value="1" {local var="trialDB"} />
			<br />
			{engine name="function" function="dateDropDown" formname="trialExpireDate" startyear="2009" setdate="{local var="trialExpireDate"}"}
			<br /><br />
		</td>
		<td class="labelTD">
			<label for="trialDB">Trial Database</label>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" name="alumniDB" id="alumniDB" value="1" {local var="alumniDB"} />
		</td>
		<td class="labelTD">
			<label for="alumniDB">Alumni Database</label>
		</td>
	</tr>

	<tr>
		<td>
			<input type="checkbox" name="mobileDB" id="mobileDB" value="1" {local var="mobileDB"} />
		</td>
		<td class="labelTD">
			<label for="mobileDB">Mobile Database</label>
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="">Access (Plain Text): </label>
		</td>
		<td>
			{engine name="function" function="webHelper_listSelect" table="accessPlainText" select="{local var="accessPlainText"}"}
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="">Access Type: </label>
		</td>
		<td>
			{engine name="function" function="webHelper_listSelect" table="accessType" select="{local var="accessType"}"}
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="helpText">Help (Text):</label>
		</td>
		<td>
			<textarea name="helpText" id="helpText" cols="50" rows="10">{local var="helpText"}</textarea>
		</td>
	</tr>
	<tr>
		<td class="labelTD">
			<label for="helpURL">Help (URL):</label>
		</td>
		<td>
			<textarea name="helpURL" id="helpURL" cols="50" rows="10">{local var="helpURL"}</textarea>
		</td>
	</tr>
	
	
	<tr>
		<td class="labelTD">
			<label for="dbDesc">Database Description</label>
		</td>
		<td>
			<textarea name="dbDesc" id="dbDesc" cols="50" rows="10">{local var="dbDesc"}</textarea>
		</td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="">Resource Types:
		<td>
			{engine name="function" function="webHelper_listCheckbox" table="resourceTypes" col="name" select="{local var="resourceTypes"}}
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><hr /></td>
	</tr>
	
	<tr>
		<td class="labelTD">
			<label for="">Subject Checkbox:
		<td>
			{engine name="function" function="webHelper_listCheckbox" table="subjects" col="name" select="{local var="subjects"}}
		</td>
	</tr>
	

</table>

<input type="submit" name="submitDB" value="Submit Database">

</form>

<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>