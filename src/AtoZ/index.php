<?php
require "../engineHeader.php";

$pageHeader = (!empty($_GET['HTML']['id']) && (preg_match('/^\w$/',$_GET['HTML']['id']) == 1))?$_GET['HTML']['id']:"a";

if ($pageHeader == "num") {
	$pageHeader = "Number";
}

$localvars->set("pageHeader",(!empty($pageHeader))?$pageHeader:"Error");

$dbObject  = new databases;
$databases = $dbObject->getByLetter($pageHeader);
$localvars->set("databases",lists::databases($databases));

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

<h3>Databases by Title: {local var="pageHeader"} </h3>

{local var="databases"}

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>