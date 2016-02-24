<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByType(array("newDatabase","trialDatabase"));

$localvars->set("highlighted_databases",lists::databases($databases,false));

$localvars->set("homepage","true");

templates::display('header'); 
recurseInsert("stylesheets/homepage.css");

?>

<!-- Homepage Content -->
<span class="hp">
	<h2>Database Search</h2>

	<?php recurseInsert("includes/searchBox.php","php") ?>
	<div style="clear:both;"></div>

	<h2>Databases by Title</h2>
	{local var="letters"}

	<?php recurseInsert("leftnav.php","php") ?>

	<div style="clear:both;"></div>

	<h2>Databases by Subject</h2>
	{local var="subjects"}
</span>

<!-- <script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script> -->

<?php
templates::display('footer'); 
?>