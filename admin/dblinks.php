<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

$engine->localVars('pageTitle',"Database Management: Add Database");

recurseInsert("dbTableList.php","php");
$engine->dbConnect("database","databases",TRUE);

$engine->accessControl("ADgroup","Domain Users",TRUE);
$engine->accessControl("denyAll",null,null);
$engine->accessControl("build");

$engine->eTemplate("include","header");
?>

<!-- Page Content Goes Below This Line -->

<?php

$error = FALSE;

$sql = "SELECT * FROM dbList WHERE status='1' ORDER BY name";

$engine->openDB->sanitize = FALSE;
$sqlResult = $engine->openDB->query($sql);

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

<tr style="background-color: <?php print $color; ?>;font-size:smaller;">
	<td>
		<?php print $row['name']; ?>
	</td>
	<td>
		<a href="http://www.libraries.wvu.edu/databases/connect.php?<?php print $row['URLID']; ?>=INVS">http://www.libraries.wvu.edu/databases/connect.php?<?php print $row['URLID']; ?>=INVS</a>
	</td>
</tr>

<?php		
}
?>
		
	</table>

<?php } ?>

<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>