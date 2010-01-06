<p>
	<?php
		if (strcmp($_POST["submit"], "View Files") == 0)
			print "<div id='view' style='display:block'>";
		else
			print "<div id='view' style='display:none'>";
	?>
		<p>Please select the year you wish to view and click &lt;View Files&gt;:</p>
			
		<?php
			print "<p><select name=\"directory\">";
			
			if (strcmp($_POST["submit"], "View Files") == 0)
				listAllYears($_POST['directory']);
			else 
				listAllYears("");

			print "</select>";
			print "<INPUT type=\"submit\" name=\"submit\" value=\"View Files\">";
			print "<INPUT type=\"reset\"></p>";
			
			if (strcmp($_POST["submit"], "View Files") == 0) {
				listAllFiles($_POST['directory']);	
			}
		?>
	</div>
</p>
