<?php

$localvars = localvars::getInstance();

$dbObject  = new databases;
$databases = $dbObject->getByType($localvars->get("searchType"));
$localvars->set("databases",lists::databases($databases));

?>

<div class="database-content-holder">
{local var="databases"}
</div>