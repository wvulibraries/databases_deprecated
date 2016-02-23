<?php

require "../engineHeader.php";

// require_once "/home/www.libraries.wvu.edu/public_html/email/emailCaptcha.php";
// genTextCaptcha();

templates::display('header'); 

?>

<!-- Page Content Goes Below This Line -->

{local var="letters"}

<h2>eResource Error Report</h2>

<p>
	If you are having a problem with a database or online resource, please let 
	us know.
</p>

<form class ="error-report" action="https://lib.wvu.edu/email/email.php" method="post" enctype="multipart/form-data">

{csrf}

    <input name="emailcgi_server" type="hidden" value="smtp.wvu.edu" />
    <input name="emailcgi_subject" type="hidden" value="Databases Problem Report" />

	<!-- Form fields to include in message -->
	<input name="emailcgi_fields" type="hidden" value="Database-or-Journal,Problem,Name,Email,Phone,attachment" />
	<!-- Form fields with are required -->
	<input name="emailcgi_req_fields" type="hidden" value="Database-or-Journal,Problem" />

	<!-- File to display on success -->
	<input type="hidden" name="emailcgi_rd_url" value="https://lib.wvu.edu/databases/report/thanks/">
	<!-- File to display on error -->
	<input type="hidden" name="emailcgi_rd_error_url" value="https://lib.wvu.edu/databases/report/thanks/">
	<!-- Require emailcgi_email_sndr to be an 'onCampus' email address (as defined by email::internalEmailAddr()) -->
	<!-- <input type="hidden" name="emailcgi_oncampus" value="yes"> -->
	<!-- Use HTML formatting for email -->
	<input type="hidden" name="emailcgi_html_formatted" value="true">


<label for="Database-or-Journal">
	Database or Journal Where the Problem was Experienced
</label>
<input type="text" name="Database-or-Journal" value="" id="Database-or-Journal" />

<br /><br />

<label for="problem">Describe the issue</label>
<textarea name="Problem" value="" id="problem"></textarea>
<p id="optional-citation">
	<u>Optional</u>: Include the citation of the book or article you are trying to 
	access.
</p>

<p>
	May we contact you for clarification or to inform you of the problem's 
	resolution?
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

<div id="screenshot">
    <p>
        <label class="bold" for="attachment">File:</label>
        <input type="file" name="attachment[]" multiple>
    </p>
</div>

<p>
	{local var="textCaptcha_question"} <br />
	<input type="text" name="captchaAnswer"><br />
</p>

<input type="submit" value="Report Problem" name="submit_report">

</form>

<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>