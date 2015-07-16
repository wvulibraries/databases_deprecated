<?php

$localvars = localvars::getInstance();

print "<pre>";
var_dump($_SERVER['REQUEST_URI']);
print "</pre>";

if (!preg_match("/\/databases\/?(index.php)?$/",$_SERVER['REQUEST_URI'])) {
	$localvars->set("enableBreadcrumbClicking","breadcrumbClicking");
}

?>