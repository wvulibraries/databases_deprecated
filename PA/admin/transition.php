<?php
	if ($_POST["loginSubmit"]) {
		include("/home/library/phpincludes/logging.php");
		
		if(success($_POST["username"],$_POST["password"])) {
			session_start();
			$_SESSION['user_logged'] = true; // user logged in
			$_SESSION['username'] = $_POST["username"];
			header("location:control_panel.php");
		}   
		else {
			header("location:index.php?login=loginError");
		}
	}
?>
