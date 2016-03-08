<?php
require "../../engineHeader.php";

$localvars->set("databaseHeading","Popular Databases");
$localvars->set("searchType","popular");

templates::display('header'); 
?>

<?php recurseInsert("typeBase.php","php") ?>


<?php
templates::display('footer'); 
?>