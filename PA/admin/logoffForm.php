<form method="post" action="index.php">
	<?php
		print "<input type=\"hidden\" name=\"username\" value=";
		print $_SESSION['username'];
		print ">";
	?>

	<input class="button" type="submit" name="submit" value="Logoff">
</form>
