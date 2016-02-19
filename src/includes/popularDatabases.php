<?php 

$localvars  = localvars::getInstance();

if (count($localvars->get("popularDatabases"))) { 
?>

<ul id="popular-databases">
<li>
	<span class="facets-header">{local var="topPickHeading"}</span>
	{local var="popular"}
</li>
</ul>
<?php } ?>