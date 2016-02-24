<?php
require "../engineHeader.php";

$_GET['MYSQL']['q'] = ($_GET['MYSQL']['q'] && !is_empty($_GET['MYSQL']['q']))?$_GET['MYSQL']['q']:"";
$_GET['MYSQL']['q'] = urldecode($_GET['MYSQL']['q']);
$_GET['MYSQL']['q'] = str_replace("&", "&amp;", $_GET['MYSQL']['q']);

$dbObject  = new databases;
$databases = $dbObject->find($_GET['MYSQL']['q']);
$localvars->set("databases",lists::databases($databases));
$localvars->set("displayNoResults",(is_empty($databases))?"block":"none");
$localvars->set("query",$_GET['HTML']['q']);

$localvars->set("breadcrumb_heading","Search Results: ".htmlSanitize($_GET['HTML']['q']));

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->
<h2>Database Search Results: </h2>

<p style="display: {local var="displayNoResults"}">Sorry, but there are no matching results for a database titled "<strong>{local var="query"}</strong>". Are you sure you spelled "{local var="query"}" correctly?<br><br>Please feel free to search again, or you can sort through the databases by <a href="{local var="databaseHome"}/subjects/">subject</a> or <a href="{local var="databaseHome"}/AtoZ/">title</a>.<br><br>Also, you might want to check some of the following popular databases:</p>

<style>
.facets-header {
	display: none;
}
</style>

<?php if ($localvars->get("displayNoResults") == "block") {  
recurseInsert("includes/popularDatabases.php","php");
}?>

{local var="databases"}

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>