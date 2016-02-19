<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

<div id="searchBox">
	<form class="search-wrap" method="get" action="/databases/search/" id="dbn_form">
		<label for="dbn" class="hidelabel">Label</label>
		<input id="dbn" name='q' type='text' placeholder="Databases by Name..." class="search-field" size="21" maxlength="120" />
		<button class="search-button"><i class="fa fa-search"></i>Search</button>
	</form>
</div>

{local var="letters"}

<h3>Subjects</h3>

{local var="subjects"}


<!-- Page Content Goes Above This Line -->

<!-- <script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script> -->

<?php
templates::display('footer'); 
?>