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

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

<h3>Database Search Results</h3>

<p style="display: {local var="displayNoResults"}">We do not have any databases named "<strong>{local var="query"}</strong>".  Please browse our <a href="{local var="databaseHome"}">Databases</a> by subject or title.</p>

{local var="databases"}

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>