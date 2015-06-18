<?php
require_once "../../../engineHeader.php";

if (!is_empty($_POST) || session::has('POST')) {
	$processor = formBuilder::createProcessor();
	$processor->processPost();
}

recurseInsert("includes/forms/subjects.php","php");

templates::display('header');
?>

<header>
<h1>Subject Management</h1>
</header>

<section>
{form name="Subjects" display="form"}
</section>

<section>
{form name="Subjects" display="editTable"}
</section>


<?php
templates::display('footer');
?>