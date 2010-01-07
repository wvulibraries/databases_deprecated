<?php

$engineDir = "/home/library/phpincludes/engineAPI/engine";
include($engineDir ."/engine.php");
$engine = new EngineCMS();

$engine->localVars('pageTitle',"Database Management: Add Database");

recurseInsert("dbTables.php","php");
$engine->dbConnect("database","databases",TRUE);

recurseInsert("acl.php","php");
$engine->accessControl("build");

$engine->eTemplate("include","header");
?>

<!-- Page Content Goes Below This Line -->

<?php

// Check for and expire trial databases
$sql = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<".time();
$engine->openDB->sanitize = FALSE;
$sqlResult = $engine->openDB->query($sql);
//

$error = FALSE;

$sql = "SELECT * FROM dbList ORDER BY name";

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
			<th style="width: 50px; text-align: left;">
				ID
			</th>
			<th style="width: 300px; text-align: left;">
				Title
			</th>
			<th style="width: 120px; text-align: left;">
				Status
			</th>
			<th style="width: 150px; text-align: left;">
				Trial
			</th>
		</tr>
		<tr><td colspan="4" style="background-color: #000000;"></td></tr>
		
<?php		
$count = 0;
while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {

$color = (++$count%2 == 0)?$engineVars['oddColor']:$engineVars['evenColor'];


?>

<tr style="background-color: <?= $color ?>;">
	<td>
		<a href="newdatabase.php?id=<?= $row['ID'] ?>">Edit</a>
	</td>
	<td>
		<?= $row['name'] ?>
	</td>
	<td>
		<?php
		
	        switch($row['status']) {
				case 1:
				echo '<span style="color:green;">Published</span>';
				break;
				case 2:
				echo '<span style="color:#D9E455;">Development</span>';
				break;
				case 3:
				echo '<span style="color:red;">Hidden</span>';
				break;
				default:
				echo '<span style="color:red;font-weight: bold">ERROR</span>';
			}
				
?>
	</td>
	<td>
		<?php
	    if($row['trialDatabase'] == 1) {
			print "Yes -- ".date("M d, Y",$row['trialExpireDate']);
		}
		else {
			echo "No";
		} 
		?>
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