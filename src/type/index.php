<?php
require "../engineHeader.php";

templates::display('header');
?>


<!-- Page Content Goes Below This Line -->

<?php recurseInsert("typeBase.php","php") ?>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>
