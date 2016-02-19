<?php

$localvars = localvars::getInstance();

$dbObject  = new databases;
$databases = $dbObject->getByType($localvars->get("searchType"));
$localvars->set("databases",lists::databases($databases));

$localvars->set("letters",lists::letters());

?>

{local var="letters"}

<?php if (count($popularDatabases)) { ?>
<ul id="popular-databases">
<li>
	<span class="facets-header">Librarian Top Picks<span class="facetToggle ftPlus hiding"><i class="fa fa-plus-square-o"></i></span><span class="facetToggle ftMinus"><i class="fa fa-minus-square-o"></i></span></span>
	{local var="popular"}
</li>
</ul>
<?php } ?>

<div class="database-content-holder">
{local var="databases"}
</div>