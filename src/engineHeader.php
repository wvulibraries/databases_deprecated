<?php

require_once '/home/www.libraries.wvu.edu/phpincludes/engine/engineAPI/4.0/engine.php';
$engine = EngineAPI::singleton();

require_once "/home/www.libraries.wvu.edu/public_html/includes/2014/engineHeader.php";

errorHandle::errorReporting(errorHandle::E_ALL);

// Set localVars and engineVars variables
$localvars  = localvars::getInstance();
$enginevars = enginevars::getInstance();

recurseInsert("acl.php","php"); 
recurseInsert("includes/vars.php","php");

// Setup the database connection
recurseInsert("dbTables.php","php");
require("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);


recurseInsert("includes/class_databases.php");
recurseInsert("includes/class_status.php");

$engine->localVars('pageTitle',"WVU Libraries: Databases");

status::set();
databases::expireTrials();

templates::load("library2014-backpage");

?>