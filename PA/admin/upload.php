<p>
<!--
		<p>Please select the target directory you wish to upload file:</p>
			
		<?php
			print "<p><select name=\"uploadDirectory\">";
			
			if (strcmp($_POST["submit"], "Upload File") == 0)
				listAllDirs(dirname(getcwd()), $_POST['uploadDirectory']);
			else
				listAllDirs(dirname(getcwd()), "");

			print "</select></p>";
		?>
-->	
		<p>Please select the file you wish to upload:</p>
		<input type="file" name="fileName" size="50">
		
		<?php
			print "<p><INPUT type=\"submit\" name=\"submit\" value=\"Upload File\" onClick=\"return verifyUpload(document.forms['fileManagement'].fileName);\">";
			print "<INPUT type=\"reset\"></p>";
		?>
	</div>
</p>
