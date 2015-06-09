<?php
require "../engineHeader.php";

try {

	$validate = validate::getInstance();

	if (!$validate->integer($_GET['MYSQL']['id'])) {
		throw new Exception("Invalid Subject Provided.");
	}

	if (($subjectInfo = array_shift(subjects::get($_GET['MYSQL']['id']))) === FALSE) {
		throw new Exception("Error retrieving subject information");
	}
	else if (is_empty($subjectInfo)) {
		throw new Exception("Subject not found.");
	}

	$localvars->set("databaseHeading",(!empty($subjectInfo['name']))?$subjectInfo['name']:"Invalid Subject");
	$localvars->set("subjectGuideDisplay",(!empty($subjectInfo['URL']))?"block":"none");
	$localvars->set("subjectGuideLink",(!empty($subjectInfo['URL']))?$subjectInfo['URL']:"");

	$dbObject  = new databases;
	$databases = $dbObject->getBySubject($_GET['MYSQL']['id']);
	$localvars->set("databases",lists::databases($databases));
}
catch(Exception $e) {
	
	errorHandle::errorMsg($e->message);
	$localvars->set("prettyPrint",errorHandle::prettyPrint());

}

templates::display('header'); 
?>

<!-- Page Content Goes Below This Line -->

{local var="prettyPrint"}

<div class="clearfix" id="subjectsContainer">

<h3>{local var="databaseHeading"} Databases</h3>

<p id="subjectGuideLink" style="display: {local var="subjectGuideDisplay"}">For a subject guide on this topic:<br />
	<a href="{local var="subjectGuideLink"}">{local var="subjectGuideLink"}</a>
</p>

{local var="databases"}

</div>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>