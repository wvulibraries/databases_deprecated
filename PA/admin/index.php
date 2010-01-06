<?php session_start(); ?>
<?php include("head.html"); ?>

<div id="content">
	<div id="left">
		<?php include("logonForm.php"); ?>
	</div>

	<div id="rightScroll">
		<h2>Petroleum Abstracts File Management</h2>
		
		<?php
			if (strcmp($_POST["submit"], "Logoff") == 0) {
				session_destroy();
			}
		
			if (strcmp($_GET["login"], "loginError") == 0) {
				print "<p><b>Username/Password incorrect!</b><br>";
				print "Please try to logon again...</p>";
			}
			else {
				print "<p>Please logon to continue...</p>";
			}
		?>
	</div>
</div>

<?php include("footer.html"); ?>
