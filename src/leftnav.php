<?php

$localvars = localvars::getInstance();
$localvars->set("currentStatus",status::build());

$localvars->set("resourceTypes",lists::resourceTypes());

?>

<div id="sidebar">
	<div id="facets">
		<h2>Narrow Your Results</h2>
		<ul>
			<li class="facets-header">Types of Databases
				<span class="facetToggle">+</span>
			</li>
			<ul>
				<li><a href="{local var="databaseHome"}/type/alumni/">Alumni</a><i class="fa fa-angle-right"></i></li>
				<li><a href="{local var="databaseHome"}/type/new/">New</a><i class="fa fa-angle-right"></i></li>
				<li><a href="{local var="databaseHome"}/type/trial/">Trial</a><i class="fa fa-angle-right"></i></li>
			</ul>
			<li class="facets-header">Resource Types
				<span class="facetToggle">+</span>
			</li>
			{local var="resourceTypes"}
		</ul>
	</div>
</div>