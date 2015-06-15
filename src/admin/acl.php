<?php

$engine = EngineAPI::singleton();

accessControl::accessControl("ADgroup","libraryWeb_databases",TRUE,FALSE);
accessControl::accessControl("denyAll",null,null);

accessControl::build();
?>