<?php
require_once("/home/library/phpincludes/engine/engineAPI/3.1/engine.php");
$engine = EngineAPI::singleton();
$xml    = new syndication();

recurseInsert("dbTables.php","php");
$engine->dbConnect("database","databases",TRUE);

include("buildStatus.php");

if ($xml->switchTemplate("syn.xml","/home/library/public_html/databases/includes") === FALSE) {
	print "Error finding XML Template";
	exit();
}

$sql = sprintf("SELECT * FROM dbList WHERE %s",
	$status
	);

if (isset($engine->cleanGet['MYSQL']['subjects']) && validate::integer($engine->cleanGet['MYSQL']['subjects'])) {
	$sql = sprintf("select * from dbList JOIN databases_subjects where databases_subjects.subjectID='%s' AND dbList.ID=databases_subjects.dbID AND (%s) ORDER BY dbList.name",
		$engine->cleanGet['MYSQL']['subjects'],
		$status
		);
}
else if (isset($engine->cleanGet['MYSQL']['letter']) && validate::alphaNoSpaces($engine->cleanGet['MYSQL']['letter'])) {

	if ($engine->cleanGet['MYSQL']['letter'] == "num") {
		$engine->cleanGet['MYSQL']['letter'] = "1' OR name REGEXP '^2' OR name REGEXP '^3' OR name REGEXP '^4' OR name REGEXP '^5' OR name REGEXP '^6' OR name REGEXP '^7' OR name REGEXP '^8' OR name REGEXP '^9' OR name REGEXP '^0";
	}

	$sql = sprintf("select * from dbList WHERE (name REGEXP '^%s') AND (%s) ORDER BY name",
		$engine->cleanGet['MYSQL']['letter'],
		$status
		);
}
else if (isset($engine->cleanGet['MYSQL']['type']) && validate::alphaNoSpaces($engine->cleanGet['MYSQL']['type'])) {

	$sql = sprintf("select * from dbList WHERE `%s`='1' AND (%s) ORDER BY name",
		$engine->cleanGet['MYSQL']['type'],
		$status
		);

}
else if (isset($engine->cleanGet['MYSQL']['resourceType']) && validate::integer($engine->cleanGet['MYSQL']['resourceType'])) {
	$sql = sprintf("select * from dbList JOIN databases_resourceTypes where databases_resourceTypes.resourceID='%s' AND dbList.ID=databases_resourceTypes.dbID AND (%s) ORDER BY dbList.name",
		$engine->cleanGet['MYSQL']['resourceType'],
		$status
		);
}

$xml->syndicationMetadata("title","WVU Libraries Databases");
$xml->syndicationMetadata("link","http://www.libraries.wvu.edu/collections/");
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

$sqlResult = $engine->openDB->query($sql);

if (!$sqlResult['result']) {
	errorHandle::newError(__METHOD__."() - ".$sqlResult['error'], errorHandle::DEBUG);
	exit;
}

while($row = mysql_fetch_array($sqlResult['result'],  MYSQL_ASSOC)) {

	$item = array();

	$item['title']           = $row['name'];
	$item['link']            = $row['url'];
	$item['moreInfo']        = "http://www.libraries.wvu.edu/databases/database.php?id=".$row['ID'];
	$item['status']          = $row['status'];
	$item['years']           = $row['yearsOfCoverage'];
	$item['description']     = $row['description'];
	$item['vendor']          = $row['vendor'];
	$item['offCampusURL']    = $row['offCampusURL'];
	$item['updated']         = $row['updated'];
	$item['accessType']      = $row['accessType'];
	$item['fullTextDB']      = $row['fullTextDB'];
	$item['newDatabase']     = $row['newDatabase'];
	$item['trialDatabase']   = $row['trialDatabase'];
	$item['access']          = $row['access'];
	$item['help']            = $row['help'];
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