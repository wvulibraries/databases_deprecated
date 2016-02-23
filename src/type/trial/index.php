<?php
require "../../engineHeader.php";

$localvars->set("databaseHeading","Trial");
$localvars->set("searchType","trialDatabase");

templates::display('header'); 
?>

<?php recurseInsert("typeBase.php","php") ?>


<?php
templates::display('footer'); 
?>