<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByType(array("trialDatabase")); //"newDatabase",

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

	<div style="clear:both;"></div>

	<?php if(!is_empty($localvars->get("highlighted_databases"))) {?>
	<div id="highlighed-databases">
		<h2>Trial Databases</h2>
		{local var="highlighted_databases"}
	</div>
	<?php } ?>

	<div style="clear:both;"></div>

	<h2>Databases by Subject</h2>
	{local var="subjects"}
</span>

<?php
templates::display('footer');
?>
