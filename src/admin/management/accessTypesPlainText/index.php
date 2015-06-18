<?php
require_once "../../../engineHeader.php";

if (!is_empty($_POST) || session::has('POST')) {
	$processor = formBuilder::createProcessor();
	$processor->processPost();
}

recurseInsert("includes/forms/accessPlainText.php","php");

templates::display('header');
?>

<header>
<h1>Access Plain Text Management</h1>
</header>

<section>
{form name="accessPlainText" display="form"}
</section>

<section>
{form name="accessPlainText" display="editTable"}
</section>


<?php
templates::display('footer');
?>