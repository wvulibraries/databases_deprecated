<?php
require "../engineHeader.php";

$pageHeader = (!empty($_GET['HTML']['id']) && (preg_match('/^\w$/',$_GET['HTML']['id']) == 1))?$_GET['HTML']['id']:"a";

if ($_GET['HTML']['id'] == "num") {
	$pageHeader = "num";
}

$localvars->set("pageHeader",(!empty($pageHeader))?$pageHeader:"Error");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByLetter($pageHeader);
$localvars->set("databases",lists::databases($databases));

$localvars->set("databaseHeadingByTitle",sprintf("By title '%s'",strtoupper($localvars->get("pageHeader"))));
$localvars->set("databaseHeading",sprintf("By title '%s'",strtoupper($localvars->get("pageHeader"))));

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<div class="database-content-holder">

{local var="databases"}

</div>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>