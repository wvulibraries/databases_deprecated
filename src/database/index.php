<?php

require "../engineHeader.php";

try {

	$validate = validate::getInstance();
	$dbObject = new databases;
	
	if (!$validate->integer($_GET['MYSQL']['id'])) {
		throw new Exception("Invalid Database Provided.");
	}

	if (($database = $dbObject->get($_GET['MYSQL']['id'])) === FALSE) {
		throw new Exception("Error retrieving database information.");
	}
	else if (is_empty($database)) {
		throw new Exception("Database not found.");
	}

	$dbObject->buildLocalvars($database);

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

	<h3>{local var="database_name"}</h3>

	<p><a href="{local var="database_connection_url"}">Connect to Database</a></p>

	<p id="fullTextRow">
		{local var="database_fulltext"}
		{local var="database_trial"}
		{local var="database_new"}
	</p>

	<p style="display: {local var="database_trialText_display"}"><span class=\"trialText\">Trial ends on {local var="database_trialDate"}</span></p>

	<div class="infoBlock" style="display: {local var="database_description_display"}">
		<div class="infoKey">
			<span class="boldText">Description:</span>
		</div>

		<div class="infoKeyInfo">
			{local var="database_description"}
		</div>
	</div>
		
	<div class="infoBlock" style="display: {local var="database_yearsOdCoverage_display"}">
		<div class="infoKey">
			<span class="boldText">Years of Coverage:</span>
		</div>

		<div class="infoKeyInfo">
			{local var="database_yearsOfCoverage"}
		</div>
	</div>
			
	<div class="infoBlock" style="display: {local var="database_updated_display"}">
		<div class="infoKey">
			<span class="boldText">Updated:</span>
		</div>

		<div class="infoKeyInfo">
			{local var="database_updated"}
		</div>
	</div>
		
	<div class="infoBlock" style="display: {local var="database_help_display"}">
		<div class="infoKey">
			<span class="boldText">Help:</span>
		</div>

		<div class="infoKeyInfo">
			{local var="database_help"}
		</div>
	</div>
		
	<div class="infoBlock" style="display: {local var="database_access_display"}">
		<div class="infoKey">
			<span class="boldText">Access:</span>
		</div>

		<div class="infoKeyInfo">
			{local var="database_access"}
		</div>
	</div>

</div>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>