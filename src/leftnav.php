<?php

$localvars = localvars::getInstance();
$localvars->set("currentStatus",status::build());

$localvars->set("resourceTypes",lists::resourceTypes());

// Figure out which popular databases we need.
$dbObject = new databases;
if (1 == 2) {
	$popularDatabases = 1;
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
			<li class="facets-header">Types of Databases
				<span class="facetToggle">+</span>
			<li>
				<span class="facets-header">Start Here / Top Picks<span class="facetToggle">+</span></span>
				{local var="popular"}
			</li>
			<ul>
				<li><a href="{local var="databaseHome"}/type/alumni/">Alumni</a><i class="fa fa-angle-right"></i></li>
				<li><a href="{local var="databaseHome"}/type/new/">New</a><i class="fa fa-angle-right"></i></li>
				<li><a href="{local var="databaseHome"}/type/trial/">Trial</a><i class="fa fa-angle-right"></i></li>
			</ul>
			<li class="facets-header">Resource Types
				<span class="facetToggle">+</span>
			</li>
			</li>
			{local var="resourceTypes"}
		</ul>
	</div>
</div>