<?php 

$localvars  = localvars::getInstance();

if (count($localvars->get("popularDatabases"))) { 
?>

	<div class="database-content-holder poppicks">
		<span class="facets-header">{local var="topPickHeading"}</span>
		{local var="popular"}
	</div>

<?php } ?>