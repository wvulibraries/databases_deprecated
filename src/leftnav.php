<?php

$localvars = localvars::getInstance();
$localvars->set("currentStatus",status::build());

$localvars->set("resourceTypes",lists::resourceTypes());

// Figure out which popular databases we need.
$dbObject = new databases;
if ($localvars->get("subjectsPage")) {
	$popularDatabases = topPickDBs::getTopPicksForSubject($localvars->get("subjectsPage"));
}
else {
	$popularDatabases = $dbObject->getByType("popular");
}

$localvars->set("popular",lists::popular($popularDatabases));


?>

<div id="sidebar">
	<div id="facets">
		<h2>Narrow Your Results</h2>
		<ul>
			<?php if (count($popularDatabases)) { ?>
			<li>
				<span class="facets-header">Start Here / Top Picks<span class="facetToggle">+</span></span>
				{local var="popular"}
			</li>
			<?php } ?>
			<li><span class="facets-header">Types of Databases<span class="facetToggle">+</span></span>

				<ul>
					<li><a href="{local var="databaseHome"}/type/alumni/">Alumni</a><i class="fa fa-angle-right"></i></li>
					<li><a href="{local var="databaseHome"}/type/new/">New</a><i class="fa fa-angle-right"></i></li>
					<li><a href="{local var="databaseHome"}/type/trial/">Trial</a><i class="fa fa-angle-right"></i></li>
				</ul>
			</li>
			<li><span class="facets-header">Resource Types<span class="facetToggle">+</span></span>

				{local var="resourceTypes"}
			</li>
		</ul>
	</div>
</div>