<?php

$localvars = localvars::getInstance();

$localvars->set('pageTitle',"WVU Libraries: Databases");
$localvars->set("currentDisplayObjectTitle","Databases A-Z List");
$localvars->set('dbConnectionName', 'appDB');
$localvars->set("databaseHome","/databases");
$localvars->set("connectURL","/databases/connect.php");
$localvars->set("proxyURL", "http://www.libproxy.wvu.edu/login?url=");
$localvars->set("descriptionLength","300");
$localvars->set("topPickHeading","<h2>Start Here:</h2>");
$localvars->set("databaseTagTypes",array(
	// "fullTextDB"    => "Full Text",
	"newDatabase"   => "New", 
	"trialDatabase" => "Trial", 
	"alumni"        => "Alumni", 
	"mobile"        => "Mobile"
	));
$localvars->set("noPagination",array(
	"/databases/index.php",
	"/databases/database/index.php"
	));
?>