<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Connect to the database
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engine->dbConnect("database","pa",TRUE);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

// Fire up the Template Engine
$engine->localVars("pageTitle", $snippets->display("pageTitle","value"));
$engine->localVars("baseURL", $snippets->display("baseURL","value"));
$engine->eTemplate("load","database");
$engine->eTemplate("include","header");

recurseInsert("issueIndex.php","php");

$engine->eTemplate("include","footer");
?>
