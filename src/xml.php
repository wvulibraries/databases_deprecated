<?php

// @TODO update the RSS to Engine4

require_once '/home/www.libraries.wvu.edu/phpincludes/engine/engineAPI/4.0/engine.php';
$engine = EngineAPI::singleton();

errorHandle::errorReporting(errorHandle::E_ALL);

// Super quick hack to get it working
function convertString($string) {

	$string = preg_replace('/&/', '&amp;', $string);
	$string = preg_replace('/>/', "&gt;",  $string);
	$string = preg_replace('/</', "&lt;",  $string);

	return $string;
}

$localvars = localvars::getInstance();

recurseInsert("includes/vars.php","php");

// Setup the database connection
$databaseOptions = array(
	'username' => 'username',
	'password' => 'password'
);
require_once('/home/www.libraries.wvu.edu/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php');
$databaseOptions['dbName'] = 'databases';
$db                        = db::create('mysql', $databaseOptions, $localvars->get("dbConnectionName"));

recurseInsert("includes/class_databases.php");
recurseInsert("includes/class_status.php");
recurseInsert("includes/class_lists.php");
recurseInsert("includes/class_resourceTypes.php");
recurseInsert("includes/class_subjects.php");
recurseInsert("includes/class_topPickDBs.php");
recurseInsert("includes/class_vendors.php");

$xml      = new syndication();
$validate = validate::getInstance();

if ($xml->switchTemplate("syn.xml","/home/library/public_html/databases/includes") === FALSE) {
	print "Error finding XML Template";
	exit();
}


if (isset($_GET['MYSQL']['subjects']) && $validate->integer($_GET['MYSQL']['subjects'])) {
	$sql = sprintf("select dbList.* from dbList JOIN databases_subjects where databases_subjects.subjectID='%s' AND dbList.ID=databases_subjects.dbID AND (%s) ORDER BY dbList.name",
		$_GET['MYSQL']['subjects'],
		status::buildSQLStatus()
		);
}
else if (isset($_GET['MYSQL']['letter']) && $validate->alphaNoSpaces($_GET['MYSQL']['letter'])) {

	if ($_GET['MYSQL']['letter'] == "num") {
		$_GET['MYSQL']['letter'] = "1' OR name REGEXP '^2' OR name REGEXP '^3' OR name REGEXP '^4' OR name REGEXP '^5' OR name REGEXP '^6' OR name REGEXP '^7' OR name REGEXP '^8' OR name REGEXP '^9' OR name REGEXP '^0";
	}

	$sql = sprintf("select * from dbList WHERE (name REGEXP '^%s') AND (%s) ORDER BY name",
		$_GET['MYSQL']['letter'],
		status::buildSQLStatus()
		);
}
else if (isset($_GET['MYSQL']['type']) && $validate->alphaNoSpaces($_GET['MYSQL']['type'])) {

	$sql = sprintf("select * from dbList WHERE `%s`='1' AND (%s) ORDER BY name",
		$_GET['MYSQL']['type'],
		status::buildSQLStatus()
		);

}
else if (isset($_GET['MYSQL']['resourceType']) && $validate->integer($_GET['MYSQL']['resourceType'])) {
	$sql = sprintf("select * from dbList JOIN databases_resourceTypes where databases_resourceTypes.resourceID='%s' AND dbList.ID=databases_resourceTypes.dbID AND (%s) ORDER BY dbList.name",
		$_GET['MYSQL']['resourceType'],
		status::buildSQLStatus()
		);
}
else {
	$sql = sprintf("SELECT * FROM dbList WHERE %s",
	status::buildSQLStatus()
	);
}

$xml->syndicationMetadata("title","WVU Libraries Databases");
$xml->syndicationMetadata("link","http://www.libraries.wvu.edu/databases/");
$xml->syndicationMetadata("description","WVU Libraries Databases");

$xml->addItemField("title");
$xml->addItemField("link");
$xml->addItemField("moreInfo");
$xml->addItemField("status");
$xml->addItemField("years");
$xml->addItemField("description");
$xml->addItemField("vendor");
$xml->addItemField("offCampusURL");
$xml->addItemField("updated");
$xml->addItemField("accessType");
$xml->addItemField("fullTextDB");
$xml->addItemField("newDatabase");
$xml->addItemField("trialDatabase");
$xml->addItemField("access");
$xml->addItemField("help");
$xml->addItemField("helpURL");
$xml->addItemField("createDate");
$xml->addItemField("updateDate");
$xml->addItemField("urlID");
$xml->addItemField("popular");
$xml->addItemField("trialExpireDate");
$xml->addItemField("alumni");

$sqlResult = $db->query($sql);

if ($sqlResult->error()) {
	errorHandle::newError(__METHOD__."() - ".$sqlResult['error'], errorHandle::DEBUG);
	exit;
}

while($row = $sqlResult->fetch()) {

	$item = array();

	$item['title']           = convertString($row['name']);
	$item['link']            = "http://www.libraries.wvu.edu/databases/connect.php?".$row['URLID']."=INVS";
	$item['moreInfo']        = "http://www.libraries.wvu.edu/databases/database/?id=".$row['ID'];
	$item['status']          = $row['status'];
	$item['years']           = $row['yearsOfCoverage'];
	$item['description']     = convertString($row['description']);
	$item['vendor']          = convertString($row['vendor']);
	$item['offCampusURL']    = $row['offCampusURL'];
	$item['updated']         = $row['updated'];
	$item['accessType']      = convertString($row['accessType']);
	$item['fullTextDB']      = $row['fullTextDB'];
	$item['newDatabase']     = $row['newDatabase'];
	$item['trialDatabase']   = $row['trialDatabase'];
	$item['access']          = $row['access'];
	$item['help']            = convertString($row['help']);
	$item['helpURL']         = $row['helpURL'];
	$item['createDate']      = $row['createDate'];
	$item['updateDate']      = $row['updateDate'];
	$item['urlID']           = $row['URLID'];
	$item['popular']         = $row['popular'];
	$item['trialExpireDate'] = $row['trialExpireDate'];
	$item['alumni']          = $row['alumni'];

	$xml->addItem($item);
	unset($item);	

}

print $xml->buildXML();
?>
