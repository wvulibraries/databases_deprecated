<?php

$localvars = localvars::getInstance();

$dbObject  = new databases;
$databases = $dbObject->getByType($localvars->get("searchType"));
$localvars->set("databases",lists::databases($databases));

?>

<h3>{local var="pageHeader"} Databases</h3>

<div class="database-content-holder">
{local var="databases"}
</div>