<?php

require "engineHeader.php";

$localvars->set("subjects",lists::subjects());

$localvars = localvars::getInstance();
//$localvars->set("adminDisplay","display:none;");
$localvars->set("letters",lists::letters());

$dbObject  = new databases;
$databases = $dbObject->getByType(array("trialDatabase")); //"newDatabase",

$localvars->set("highlighted_databases",lists::databases($databases,false));
$localvars->set("databaseHeading", "Search Databases"); 
$localvars->set("databaseHeadingClass", "hidden-text");
$localvars->set("homepage","true");

templates::display('header');
recurseInsert("stylesheets/homepage.css");

?>

<!-- Homepage Content -->
<span class="hp">
	<span class="hpl">
		<h2>Database Search</h2>

		<?php recurseInsert("includes/searchBox.php","php") ?>
		<div style="clear:both;"></div>

		<h2>Databases by Title</h2>
		{local var="letters"}

		<div style="clear:both;"></div>

		<h2>Databases by Subject</h2>
		{local var="subjects"}
	</span>

	<?php if(!is_empty($localvars->get("highlighted_databases"))) {?>
	<span class="hpr">
		<span class="hprwrap">
			<h2>Trial Databases</h2>
			{local var="highlighted_databases"}
	</span></span>

	<style>
		.hpl {
			width: 100%;
			display: block;
			float: left;
		}
		.hpr {
			width: 100%;
			display: block;
			float: left;
		}
		.hprwrap {
			display: block;
			float: left;
			border: none;
			padding: 40px 0px;
		}
		.hprwrap h2 {
			margin-top: 0 !important;
		}
		@media screen and (min-width: 1024px) {
			.hpl {
				width: 66%;
			}
			.hpr {
				width: 34%;
			}
			.hprwrap {
				border: 1px solid #EAAA00;
				padding: 20px;
			}
		}
	</style>
		<?php } ?>
</span>

<div style="clear:both;"></div>

<div class="hphelp">
    <?php recurseInsert("includes/database_help.php","php") ?>
</div>

<?php
templates::display('footer');
?>
