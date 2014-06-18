<?php
global $engine;

//$engine->accessControl("IP","192.168.119.*",TRUE,FALSE);
$engine->accessControl("ADgroup","libraryWeb_PA",TRUE,FALSE);
$engine->accessControl("denyAll",TRUE);

