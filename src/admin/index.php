<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

$engine->localVars('pageTitle',"Database Management");

recurseInsert("dbTables.php","php");
$engine->dbConnect("database","databases",TRUE);

recurseInsert("acl.php","php");
$engine->accessControl("build");

$engine->eTemplate("include","header");
?>

<!-- Page Content Goes Below This Line -->


<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>