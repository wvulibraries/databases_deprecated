<?php 

$localvars  = localvars::getInstance();

if (count($localvars->get("popularDatabases"))) { 
?>

	<span class="facets-header">{local var="topPickHeading"}</span>
	{local var="popular"}

<?php } ?>