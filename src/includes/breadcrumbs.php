<?php

$localvars = localvars::getInstance();

if (is_array($localvars->get("breadcrumb_heading"))) {

	$allResults = "";
	foreach ($localvars->get("breadcrumb_heading") as $breadcrumb) {

		$allResults .= sprintf('<li>%s</li>',$breadcrumb);

	}

}
else {
	$allResults = sprintf('<li><span class="facetLi"><a href="%s">%s</a></span></li>',
		$_SERVER['REQUEST_URI'],
		(!is_empty($localvars->get("breadcrumb_heading")))?$localvars->get("breadcrumb_heading"):$localvars->get("databaseHeading")
		);
}

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