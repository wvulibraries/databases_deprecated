<?php

$localvars = localvars::getInstance();

if (!preg_match("/\/databases\/?(index.php)?$/",$_SERVER['REQUEST_URI'])) {
	$localvars->set("enableBreadcrumbClicking","breadcrumbClicking");
}

?>

<script src="{local var="databaseHome"}/javascript/databases.js"></script>