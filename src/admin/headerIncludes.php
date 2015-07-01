
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php
// Ensure {form ...} tag is processed
new formBuilder('');

// Process formBuilder forms
if (!is_empty($_POST) || session::has('POST')) {

	$processor = formBuilder::createProcessor();
	$processor->processPost();

}

?>

{form display="assets"}

<link rel="stylesheet" href="/databases/css/admin.css" type="text/css" media="screen" />