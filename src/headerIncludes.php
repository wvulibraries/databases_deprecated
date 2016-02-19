<?php

$localvars = localvars::getInstance();

if (!preg_match("/\/databases\/?(index.php)?$/",$_SERVER['REQUEST_URI'])) {
	$localvars->set("enableBreadcrumbClicking","breadcrumbClicking");
}

if ($localvars->get("subjectsPage")) {
	$localvars->set("popularDatabases",topPickDBs::getTopPicksForSubject($localvars->get("subjectsPage")));
}
else {
	$dbObject         = new databases;
	$localvars->set("popularDatabases",$dbObject->getByType("popular"));
}

$localvars->set("popular",lists::popular($localvars->get("popularDatabases")));

?>

<script src="{local var="databaseHome"}/javascript/databases.js"></script>