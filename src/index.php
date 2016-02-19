<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<h3>Subjects</h3>

{local var="subjects"}


<!-- Page Content Goes Above This Line -->

<!-- <script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script> -->

<?php
templates::display('footer'); 
?>