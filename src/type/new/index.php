<?php
require "../../engineHeader.php";

$localvars->set("pageHeader","New");
$localvars->set("searchType","newDatabase");

templates::display('header'); 
?>

<?php recurseInsert("typeBase.php","php") ?>


<?php
templates::display('footer'); 
?>