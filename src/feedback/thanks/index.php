<?php

require "../../engineHeader.php";

$localvars->set("databaseHeading","eResource Trail Database Feedback");
$localvars->set("databaseHeading","-- Thanks");

templates::display('header');
?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<p>
Thank you for submitting feedback about a trial database.
</p>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer');
?>
