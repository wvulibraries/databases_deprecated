<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

<h3>Databases by Subject</h3>

{local var="subjects"}


<!-- Page Content Goes Above This Line -->

<!-- <script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script> -->

<?php
templates::display('footer'); 
?>