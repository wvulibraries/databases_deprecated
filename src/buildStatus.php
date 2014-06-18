<?php

$localVars['status'] = 1;
if(!empty($engine->cleanGet['HTML']['status']) && isint($engine->cleanGet['HTML']['status'])) {
	$localVars['status'] = $engine->cleanGet['HTML']['status'];
}

$status = "";
switch($localVars['status']) {
	case 1:
	case "published":
	    $status = "dbList.status='1'";
	    break;
	case 2:
	case "development":
	    $status = "dbList.status='1' OR dbList.status='2'";
	    break;
	case 3:
	case "hidden":
	    $status = "dbList.status='3'";
	    break;
	case 4:
	case "all":
	    $status = "dbList.status='1' OR dbList.status='2' OR dbList.status='3'";
	    break;
	default:
	    $status = "";
}


?>