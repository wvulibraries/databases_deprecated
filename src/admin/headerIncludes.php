<style>
.database-content {
	width: 60%;
	overflow: auto;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php
// Ensure {form ...} tag is processed
new formBuilder('');

// Process formBuilder forms
if (!is_empty($_POST) || session::has('POST')) {

	$processor = formBuilder::createProcessor();
	$processor->processPost();

}
$localvars = localvars::getInstance();
$localvars->set("adminDisplay","display:none;");

?>

{form display="assets"}

<link rel="stylesheet" href="/databases/stylesheets/admin.css" type="text/css" media="screen" />