<?php
require "../../engineHeader.php";

$localvars->set("databaseHeading","New Databases");
$localvars->set("searchType","newDatabase");

templates::display('header'); 
?>

<?php recurseInsert("typeBase.php","php") ?>


<?php
templates::display('footer'); 
?>