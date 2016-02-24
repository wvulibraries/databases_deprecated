<?php

$localvars = localvars::getInstance();

$dbObject  = new databases;
$databases = $dbObject->getByType($localvars->get("searchType"));
$localvars->set("databases",lists::databases($databases));

$localvars->set("letters",lists::letters());

?>

<!-- {local var="letters"} -->

<div class="database-content-holder">
{local var="databases"}
</div>