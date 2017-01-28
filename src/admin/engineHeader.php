<?php

require_once '/home/www.libraries.wvu.edu/phpincludes/engine/engineAPI/4.0a/engine.php';
$engine = EngineAPI::singleton();

require_once "/home/www.libraries.wvu.edu/public_html/includes/2014/engineHeader.php";

errorHandle::errorReporting(errorHandle::E_ALL);

// Set localVars and engineVars variables
$localvars  = localvars::getInstance();
$enginevars = enginevars::getInstance();

recurseInsert("acl.php","php");
recurseInsert("includes/vars.php","php");

// Setup the database connection
$databaseOptions = array(
	'username' => 'username',
	'password' => 'password'
);
require_once('/home/www.libraries.wvu.edu/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php');
$databaseOptions['dbName'] = 'databases';
$db                        = db::create('mysql', $databaseOptions, $localvars->get("dbConnectionName"));


recurseInsert("includes/class_databases.php");
recurseInsert("includes/class_status.php");
recurseInsert("includes/class_lists.php");
recurseInsert("includes/class_resourceTypes.php");
recurseInsert("includes/class_subjects.php");
recurseInsert("includes/class_topPickDBs.php");
recurseInsert("includes/class_vendors.php");

$databases = new databases;

status::set();
$databases->expireTrials();
$databases->expireNewDatabases();

templates::load("databases2015-admin");

formBuilder::process();
formBuilder::ajaxHandler();

if (!is_empty($_POST) && $_POST['MYSQL']['delete'] == "Delete") {
	header('Location: /databases/admin/');
}
?>
