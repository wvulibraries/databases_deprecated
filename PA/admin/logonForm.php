<p>
	<form method="post" action="transition.php">
		<table>
			<tr>
				<td class="itemTitle">
					Name:
				</td>
				
				<td>
					<?php
						print "<input type=\"text\" size=\"20\" maxlength=\"40\" name=\"username\" value=";
						print $_SESSION['username'];
						print ">";
					?>
				</td>
			</tr>
			
			<tr>
				<td class="itemTitle">
					Password:
				</td>
				
				<td class="itemDescription">
					<input type="password" size="20" maxlength="40" name="password">
				</td>
			</tr>
		</table>
		
		<div id="submitButton">
			<input class="button" type="submit" name="loginSubmit" value="Logon">
			<input class="button" type="reset" value="Reset">
		</div>
	</form>
</p>
