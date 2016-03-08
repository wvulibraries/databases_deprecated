<?php

require "../../engineHeader.php";

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<h2>eResource Error Report -- Error</h2>

<p>
There was an error submitting your problem. Please contact us via: <a href="https://lib.wvu.edu/about/contactus">https://lib.wvu.edu/about/contactus</a>
</p>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>