<?php

require "../engineHeader.php";

$localvars->set("breadcrumb_heading","eResource Trial Database Feedback");

if (isset($_GET['MYSQL']['dbid']) && !is_empty($_GET['MYSQL']['dbid'])) {
	$dbObject = new databases;
	$database = $dbObject->get($_GET['MYSQL']['dbid']);
	$localvars->set("database_name",$database['name']);
}

templates::display('header');

?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<h2>eResource Trial Database Feedback</h2>

<p>
	If you have any feedback regarding Trial Databases or online resource, please let
	us know.
</p>

<form class ="error-report" action="https://lib.wvu.edu/email/emailEng4.php" method="post" enctype="multipart/form-data">

{csrf}

	<input name="emailcgi_to"      type="hidden" value="eresources@mail.wvu.edu" />
  <input name="emailcgi_server"  type="hidden" value="smtp.wvu.edu" />
  <input name="emailcgi_subject" type="hidden" value="Databases Problem Report" />

	<!-- Form fields to include in message -->
	<input name="emailcgi_fields" type="hidden" value="Database-or-Journal,Feedback,Name,Email,Phone" />
	<!-- Form fields with are required -->
	<input name="emailcgi_req_fields" type="hidden" value="Database-or-Journal,Problem" />

	<!-- File to display on success -->
	<input type="hidden" name="emailcgi_rd_url" value="https://lib.wvu.edu/databases/report/thanks/">
	<!-- File to display on error -->
	<input type="hidden" name="emailcgi_rd_error_url" value="https://lib.wvu.edu/databases/report/error/">
	<!-- Require emailcgi_email_sndr to be an 'onCampus' email address (as defined by email::internalEmailAddr()) -->
	<!-- <input type="hidden" name="emailcgi_oncampus" value="yes"> -->
	<!-- Use HTML formatting for email -->
	<input type="hidden" name="emailcgi_html_formatted" value="true">


<label for="Database-or-Journal">
	Trial Database or Journal to leave feedback for
</label>
<input type="text" name="Database-or-Journal" value="{local var="database_name"}" id="Database-or-Journal" />

<br /><br />

<label for="feedback">Feedback</label>
<textarea name="Feedback" value="" id="feedback"></textarea>

<p>
	May we contact you for additional information?
</p>

<div id="contact-container">
<label for="name">Name</label>
<input type="text" name="Name" value="" id="name" />

<br />

<label for="email">Email</label>
<input type="text" name="Email" value="" id="email" />

<br />

<label for="phone">Phone</label>
<input type="text" name="Phone" value="" id="phone" />

</div>

<input type="submit" value="Submit Feedback" name="submit_report">

</form>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer');
?>
