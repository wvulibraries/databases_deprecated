<?php 

$localvars  = localvars::getInstance();

if (count($localvars->get("popularDatabases"))) { 
?>

	<span class="facets-header">{local var="topPickHeading"}</span>

	<div class="database-content-holder poppicks">
		{local var="popular"}
	</div>
	<br><br>

<?php } ?>