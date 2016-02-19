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

<div id="sidebar">
	<div id="facets">
		<h2>Narrow Your Results</h2>
		<ul>
			<?php if ($alumniDBs || $newDBs || $trialDBs) { ?>
			<li><span class="facets-header">Types of Databases<span class="facetToggle ftPlus hiding"><i class="fa fa-plus-square-o"></i></span><span class="facetToggle ftMinus"><i class="fa fa-minus-square-o"></i></span></span>

				<ul>
					<?php if ($alumniDBs) { ?>
					<li data-breadcrumb="Alumni" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/alumni/">Alumni</a><i class="fa fa-angle-right"></i></li>
					<?php } ?>
					<?php if ($newDBs) { ?>
					<li data-breadcrumb="New" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/new/">New</a><i class="fa fa-angle-right"></i></li>
					<?php } ?>
					<?php if ($trialDBs) { ?>
					<li data-breadcrumb="Trial" class="{local var="enableBreadcrumbClicking"}"><a href="{local var="databaseHome"}/type/trial/">Trial</a><i class="fa fa-angle-right"></i></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>