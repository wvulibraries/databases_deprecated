<?php

$engineDir = "/home/library/phpincludes/engineCMS/engine";

$localVars = array(); //Do not delete this line

$localVars['pageTitle']       = "Database Managemet: Add Database";

$accessControl = array(); //Do not delete this line
$accessControl['AD']['Groups']['Domain Users'] = 1;

// Fire up the Engine
include($engineDir ."/engineHeader.php");
?>

<!-- Page Content Goes Below This Line -->

<?php

$error = FALSE;

$sql = "SELECT * FROM dbList WHERE status='1' ORDER BY name";

$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	$error = TRUE;
	print webHelper_errorMsg("SQL Error:".$sqlResult['error']."<br /> SQL:".$sql);
}

?>

<?php if ($error == FALSE) { ?>

	<table border="0" cellpadding="1" cellspacing="0">
		<tr style="background-color: #EEEEFF;">
			<th style="width: 150px; text-align: left;">
				Title
			</th>
			<th style="text-align: left;">
				URL
			</th>
		</tr>
		<tr><td colspan="2" style="background-color: #000000;"></td></tr>
		
<?php		
$count = 0;
while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {

$color = (++$count%2 == 0)?$engineVars['oddColor']:$engineVars['evenColor'];

?>

<tr style="background-color: <?= $color ?>;font-size:smaller;">
	<td>
		<?= $row['name'] ?>
	</td>
	<td>
		<a href="http://www.libraries.wvu.edu/databases/connect.php?<?= $row['URLID'] ?>=INVS">http://www.libraries.wvu.edu/databases/connect.php?<?= $row['URLID'] ?>=INVS</a>
	</td>
</tr>

<?php		
}
?>
		
	</table>

<?php } ?>

<!-- Page Content Goes Above This Line -->

<?php
include($engineDir ."/engineFooter.php");
?>