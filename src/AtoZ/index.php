<?php
require "../engineHeader.php";

$pageHeader = (!empty($_GET['HTML']['id']) && (preg_match('/^\w$/',$_GET['HTML']['id']) == 1))?$_GET['HTML']['id']:"a";

if (isset($_GET['HTML']) && $_GET['HTML']['id'] == "num") {
	$pageHeader = "num";
}

$localvars->set("breadcrumb_heading",(!empty($pageHeader))?"by Title: ".$pageHeader:"Error");
$localvars->set("pageHeader",(!empty($pageHeader))?$pageHeader:"Error");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByLetter($pageHeader);
$localvars->set("databases",lists::databases($databases));

$localvars->set("databaseHeadingByTitle",sprintf("%s",strtoupper($localvars->get("pageHeader"))));
$localvars->set("database_heading_middle","Databases by Title:");
templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<?php recurseInsert("includes/popularDatabases.php","php"); ?>

<div class="database-content-holder">

{local var="databases"}

</div>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>