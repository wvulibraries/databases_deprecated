<?php

global $engine;

$engine->accessControl("ADgroup","webDatabaseAdmin",TRUE);
$engine->accessControl("denyAll",null,null);
?>