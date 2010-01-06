<p>
		<p>Please select the file you wish to delete:</p>
			
		<?php
			print "<p><select name=\"deleteDirectory\">";
			
			if (strcmp($_POST["submit"], "Delete File") == 0 || strcmp($_POST["submit_delete"], "List Files") == 0)
				listAllYears($_POST['deleteDirectory']);
			else 
				listAllYears("");

			print "</select>";
			print "<INPUT type=\"submit\" name=\"submit_delete\" value=\"List Files\">";		
			print "<select name=\"deleteFile\">";
			
			if (strcmp($_POST["submit_delete"], "List Files") == 0)
				listAllFilesAsList($_POST['deleteDirectory']);
			else
				print "<option></option>";
				
			print "</select></p>";
			
			if (strcmp($_POST["submit_delete"], "List Files") == 0) {
				print "<p><INPUT type=\"submit\" name=\"submit\" value=\"Delete File\" onClick=\"return verifyDelete(document.forms['fileManagement'].deleteDirectory, document.forms['fileManagement'].deleteFile);\">";
				print "<INPUT type=\"reset\"></p>";
			}
		?>
	</div>
</p>
