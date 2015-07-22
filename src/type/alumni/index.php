<?php
require "../../engineHeader.php";

$localvars->set("databaseHeading","Alumni");
$localvars->set("searchType","alumni");

templates::display('header'); 
?>

<?php recurseInsert("typeBase.php","php") ?>


<?php
templates::display('footer'); 
?>