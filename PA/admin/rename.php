<p>
		<p>Please select the file you wish to rename:</p>
			
		<?php
			print "<p><select name=\"renameDirectory\">";
			
			if (strcmp($_POST["submit"], "Rename File") == 0 || strcmp($_POST["submit_rename"], "List Files") == 0)
				listAllYears($_POST['renameDirectory']);
			else 
				listAllYears("");

			print "</select>";
			print "<INPUT type=\"submit\" name=\"submit_rename\" value=\"List Files\">";		
			print "<select name=\"renameFile\">";
			
			if (strcmp($_POST["submit_rename"], "List Files") == 0)
				listAllFilesAsList($_POST['renameDirectory']);
			else
				print "<option></option>";
				
			print "</select></p>";
			
			if (strcmp($_POST["submit_rename"], "List Files") == 0) {
				print "Please enter a new file name: ";
				print "<INPUT TYPE=\"TEXT\" NAME=\"newName\" VALUE=\"\" SIZE=\"25\" MAXLENGTH=\"50\"></p>";
				print "<p><INPUT type=\"submit\" name=\"submit\" value=\"Rename File\" onClick=\"return verifyRename(document.forms['fileManagement'].newName);\">";
				print "<INPUT type=\"reset\"></p>";
			}
		?>
	</div>
</p>
