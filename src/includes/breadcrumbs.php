<?php

$localvars = localvars::getInstance();

$allResults = sprintf('<li><span class="facetLi"><a href="%s">%s</a></span></li>',$_SERVER['REQUEST_URI'],$localvars->get("databaseHeading"));

if (!is_empty($localvars->get("enableBreadcrumbClicking"))) {
	$localvars->set("breadCrumbs",$allResults);
}

?>


<div class ="database-content-facets">
	<ul class="database-content-facets-ul">
		<li><i class="fa fa-home"></i><a href="/">Home</a></li>
		<li><a href="{local var="databaseHome"}">Databases</a></li>
		{local var="breadCrumbs"}
	</ul>
</div>