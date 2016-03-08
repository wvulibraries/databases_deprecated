<?php

require "../engineHeader.php";

$localvars->set("subjects",lists::subjects());
$localvars->set("breadcrumb_heading","Subjects");
$localvars->set("database_heading_middle","Databases by Subject:");

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

{local var="prettyPrint"}

{local var="subjects"}

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>