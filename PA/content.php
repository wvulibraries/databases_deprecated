<?php
	include("/home/library/phpincludes/paConnectionFunctions.php");
	$conn = connect($dbhost, $dbuser, $dbpass, $dbname);
	$query = sprintf("SELECT name, type, size, content FROM paFiles WHERE name = '%s'",
				mysql_real_escape_string($_GET["filename"]));
	$result = mysql_query($query);
	list($name, $type, $size, $content) = mysql_fetch_array($result);
	header("Content-length: $size");
	header("Content-type: $type");
	header("Content-Disposition: inline; filename=$name");
	echo $content;
	disconnect($conn);
?>
