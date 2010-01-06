<p>
	<script>
		function stopRKey(evt) {
			var evt = (evt) ? evt : ((event) ? event : null);
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

			if ((evt.keyCode == 13) && ((node.type=="text") || (node.type=="file")))
				return false;
		}
	
		function toggle(choice){
			var item1 = document.getElementById('view');
			var item2 = document.getElementById('upload');
			var item3 = document.getElementById('rename');
			var item4 = document.getElementById('delete');
//			var item5 = document.getElementById('createDir');
//			var item6 = document.getElementById('removeDir');
			
			if (choice == 'V') {
				item1.style.display = 'block';
				item2.style.display = 'none';
				item3.style.display = 'none';
				item4.style.display = 'none';
//				item5.style.display = 'none';
//				item6.style.display = 'none';
			}
			else if (choice == 'U') {
				item1.style.display = 'none';
				item2.style.display = 'block';
				item3.style.display = 'none';
				item4.style.display = 'none';
//				item5.style.display = 'none';
//				item6.style.display = 'none';
			}
			else if (choice == 'R') {
				item1.style.display = 'none';
				item2.style.display = 'none';
				item3.style.display = 'block';
				item4.style.display = 'none';
//				item5.style.display = 'none';
//				item6.style.display = 'none';
			}
			else if (choice == 'D') {
				item1.style.display = 'none';
				item2.style.display = 'none';
				item3.style.display = 'none';
				item4.style.display = 'block';
//				item5.style.display = 'none';
//				item6.style.display = 'none';
			}
//			else if (choice == 'CD') {
//				item1.style.display = 'none';
//				item2.style.display = 'none';
//				item3.style.display = 'none';
//				item4.style.display = 'none';
//				item5.style.display = 'block';
//				item6.style.display = 'none';
//			}
//			else if (choice == 'RD') {
//				item1.style.display = 'none';
//				item2.style.display = 'none';
//				item3.style.display = 'none';
//				item4.style.display = 'none';
//				item5.style.display = 'none';
//				item6.style.display = 'block';
//			}
		}
		
		function verifyDelete(deleteDirectory, deleteFile) {
			var answer = confirm("Are you sure you want to delete " + deleteDirectory.options[deleteDirectory.selectedIndex].value + "/" + deleteFile.options[deleteFile.selectedIndex].value + "?");
			
			if (!answer)
				return false;
		}
		
		function verifyUpload(fileName) {
			if (!fileName.value) {
				alert("You must select a file to be uploaded!");
				return false;
			}
		}
		
		function verifyRename(fileName) {
			if (!fileName.value) {
				alert("You must enter the new filename!");
				return false;
			}
		}
		
		document.onkeypress = stopRKey;
	</script>

	<ul>
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="V" onclick="toggle('V')"
		
			<?php
				if (strcmp($_POST["submit"], "View Files") == 0)
					print "checked";
			?>
		
			>View Files
		</li>
		
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="U" onclick="toggle('U')"
			
			<?php
				if (strcmp($_POST["submit"], "Upload File") == 0)
					print "checked";
			?>
			
			>Upload File
		</li>
		
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="R" onclick="toggle('R')"
			
			<?php
				if (strcmp($_POST["submit"], "Rename File") == 0 || strcmp($_POST["submit_rename"], "List Files") == 0)
					print "checked";
			?>

			>Rename File
		</li>
		
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="D" onclick="toggle('D')"
			
			<?php
				if (strcmp($_POST["submit"], "Delete File") == 0 || strcmp($_POST["submit_delete"], "List Files") == 0)
					print "checked";
			?>
			
			>Delete File
		</li>
<!-- Of no use for PA site!	
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="CD" onclick="toggle('CD')"
			
			<?php
				if (strcmp($_POST["submit"], "Create Directory") == 0)
					print "checked";
			?>

			>Create Directory
		</li>
		
		<li>
			<INPUT TYPE=RADIO NAME="choice" VALUE="RD" onclick="toggle('RD')"
			
			<?php
				if (strcmp($_POST["submit"], "Remove Directory") == 0)
					print "checked";
			?>
			
			>Remove Directory
		</li>
-->
	</ul>
</p>
