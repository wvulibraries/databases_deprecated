<?php
$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

// Connect to the database
$engine->dbConnect("database","pa",TRUE);

// Instantiate the snippets class
$GLOBALS['snippetObject'] = $snippets = new Snippet($engine,'snippets','value');

if(array_key_exists('id', $engine->cleanGet['MYSQL']) and is_numeric($engine->cleanGet['MYSQL']['id'])){
    // Get all years that are available in the database
    $sql = sprintf("SELECT name, type, size, content FROM paFiles WHERE id = '%s' LIMIT 1", $engine->cleanGet['MYSQL']['id']);
    $engine->openDB->sanitize = FALSE;
    $sqlFile                  = $engine->openDB->query($sql);
}

// Display the file
if(isset($sql) and $sqlFile['affectedRows']){
    list($name, $type, $size, $content) = mysql_fetch_array($sqlFile['result']);
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: inline; filename=$name");
    echo $content;
    exit();
}else{

    // Fire up the Template Engine
    $engine->localVars("pageTitle", $snippets->display("pageTitle","value"));
    $engine->localVars("baseURL", $snippets->display("baseURL","value"));
    $engine->eTemplate("load","database");
    $engine->eTemplate("include","header");

    define("LOAD_ERROR", "No issue found with given ID.");
    recurseInsert("issueIndex.php","php");

    $engine->eTemplate("include","footer");
}