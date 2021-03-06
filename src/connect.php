<?php

// This file is linked in many places and should not be moved. 

require "engineHeader.php";

$localvars = localvars::getInstance();
$dbObject  = db::get($localvars->get('dbConnectionName'));
$validate  = validate::getInstance();
$databases = new databases;

?>

<!-- Page Content Goes Below This Line -->

<?php

if(is_empty($_GET['MYSQL'])) {
	print "Error: No database provided.";
	exit;
}

foreach ($_GET['MYSQL'] as $db=>$invs) {

	if (!$validate->integer($db) && strlen($db) > 10) {
		print "invalid database requested.";
		exit;
	}

	//@TODO this needs to be expanded for ip locations in the table. 
	$location = (ipAddr::onsite())?1:0;
	$dbInfo   = $databases->getByURLID($db);

	if ($dbInfo['accessType'] < 2 && $location < 1) {
		echo "This Database is only available while on campus.";
		exit;
	}

	$url = $dbInfo['url']; //(!is_empty($dbInfo['offCampusURL']))?$dbInfo['offCampusURL']:$dbInfo['url'];

	if ($location == 0 && $dbInfo['accessType'] == 2) {
		$url = sprintf("%s%s",$localvars->get("proxyURL"),$url);
	}

	$sql       = "INSERT into dbStats (dbID,location,accessDate,referrer,ipaddress) VALUES(?,?,?,?,?)";
	$sqlResult = $dbObject->query($sql,array($dbInfo['ID'],$location,time(),(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:"",$_SERVER['REMOTE_ADDR']));

	header("location: $url");
	
	break;
}

?>