<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

$localVars = array(); //Do not delete this line

$localVars['pageTitle']        = "WVU Libraries: Databases";
$localVars['exclude_template'] = TRUE;

$accessControl = array(); //Do not delete this line

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<!-- Page Content Goes Below This Line -->

<?php

$proxyURL  = "http://www.libproxy.wvu.edu/login?url=";

if(empty($cleanGet['MYSQL'])) {
	echo "error";
	exit;
}

foreach ($cleanGet['MYSQL'] as $db=>$invs) {

	// Determine Location
	$location = 0;
	if(onCampus()) {
		$location = 1;
	}
	
	$sql = "SELECT ID, url, offCampusURL, accessType FROM dbList WHERE URLID='$db'";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	if (mysql_num_rows($sqlResult['result']) != 1) {
		echo "Error with database selection.";
		echo "<pre>";
		print_r($cleanGet['MYSQL']);
		echo "</pre>";
		break;
	}
	
	$dbInfo = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC);
	
	if ($dbInfo['accessType'] < 2 && $location < 1) {
		echo "This Database is only available while on campus.";
		break;
	}

	$url = $dbInfo['url'];
	if ($location == 0) {
		
		// Check if there is a special off campus URL
		if(!empty($dbInfo['offCampusURL'])) {
			$url = $dbInfo['offCampusURL'];
		}
		
		// Check to see if we need the proxy server
		if ($dbInfo['accessType'] == 2) {
			$url = $proxyURL . $url;
		}
	}

	$sql = "INSERT into dbStats (dbID,location,accessDate) VALUES('".$dbInfo['ID']."','".$location."','".time()."')";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);

	//echo $location ." -- ".$url;

	header("location: $url");
	
	break;
}

?>

<!-- Page Content Goes Above This Line -->

<?php
include($engineDir ."/engineFooter.php");
?>