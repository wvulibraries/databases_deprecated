<?php
require "../engineHeader.php";

try {

	$validate = validate::getInstance();

	if (!$validate->integer($_GET['MYSQL']['id'])) {
		throw new Exception("Invalid Resource Type Provided.");
	}

	if (($resourceType = resourceTypes::get($_GET['MYSQL']['id'])) === FALSE) {
		throw new Exception("Error retrieving Resource Type information");
	}
	else if (is_empty($resourceType)) {
		throw new Exception("Resource Type not found.");
	}

	$resourceType = $resourceType[0];

	$localvars->set("databaseHeading",(!is_empty($resourceType['name']))?$resourceType['name']:"Invalid Resource Type");

	$dbObject  = new databases;
	$databases = $dbObject->getByResourceType($_GET['MYSQL']['id']);
	$localvars->set("databases",lists::databases($databases));
}
catch(Exception $e) {

	errorHandle::errorMsg($e->getMessage());
	$localvars->set("prettyPrint",errorHandle::prettyPrint());

}

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

{local var="prettyPrint"}

<div class="clearfix" id="subjectsContainer">

<h3>{local var="databaseHeading"} Databases</h3>

{local var="databases"}

</div>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>