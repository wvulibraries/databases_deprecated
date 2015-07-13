<?php

$localvars = localvars::getInstance();

$test = '<li><span class="facetLi"><a href="#">All Results</a></span></li>';
$localvars->set("breadCrumbs","");

?>


<div class ="database-content-facets">
	<ul class="database-content-facets-ul">
		<li><i class="fa fa-home"></i><a href="/">Home</a></li>
		<li><a href="{local var="databaseHome"}">Databases</a></li>
		{local var="breadCrumbs"}
	</ul>
</div>