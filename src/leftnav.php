<?php

$localvars = localvars::getInstance();
$localvars->set("currentStatus",status::build());

$localvars->set("resourceTypes",lists::resourceTypes());

// Figure out which popular databases we need.
$dbObject = new databases;

$alumniDBs = count($dbObject->getByType("alumni"));
$newDBs    = count($dbObject->getByType("newDatabase"));
$trialDBs  = count($dbObject->getByType("trialDatabase"));

?>

<?php if ($alumniDBs || $newDBs || $trialDBs) { ?>

	<h2>Database Types</h2>

	<?php if ($alumniDBs) { ?>
		<ul class="datatype">
			<li data-breadcrumb="Alumni" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/alumni/">Alumni</a></li>
			<?php } ?>
			<?php if ($newDBs) { ?>
			<li data-breadcrumb="New" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/new/">New</a></li>
			<?php } ?>
			<?php if ($trialDBs) { ?>
			<li data-breadcrumb="Trial" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/trial/">Trial</a></li>
	<?php } ?>
		</ul>
<?php } ?>