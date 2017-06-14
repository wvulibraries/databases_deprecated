<?php

require "../../engineHeader.php";

$localvars->set("databaseHeading","eResource Error Report Confirmation");
$localvars->set("databaseHeading","-- Thanks");
templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}
<p>
Thank you for submitting a problem.
</p>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>