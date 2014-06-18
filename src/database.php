<?php

require_once("/home/library/public_html/includes/engineHeader.php");

$engine->localVars('pageTitle',"WVU Libraries: Databases");

$engine->eTemplate("load","library2012.2col.right");

recurseInsert("dbTables.php","php");
require_once("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

// Fire up the Engine
$engine->eTemplate("include","header");
?>

<?php

if (!isint($engine->cleanGet['MYSQL']['id'])) {
	print webHelper_errorMsg("Invalid Database Requested");
}
else {
$sql = sprintf("SELECT * FROM dbList WHERE ID='%s'",
	$engine->cleanGet['MYSQL']['id']
	);
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);

if (!$sqlResult['result']) {
	// print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
	print webHelper_errorMsg("Error retrieving database.");
}
else {
	$dbInfo = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC);
}
}
include("buildStatus.php");
recurseInsert("buildLists.php","php");

?>


<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

	<h3><?php print $dbInfo['name']; ?></h3>

	<p><a href="/databases/connect.php?<?php print $dbInfo['URLID'] ?>=INVS">Connect to Database</a></p>

	<?php if ($dbInfo['fullTextDB'] == 1 || $dbInfo['newDatabase'] == 1 || $dbInfo['trialDatabase'] == 1) { ?>
		<p id="fullTextRow">
		<?php if ($dbInfo['fullTextDB'] == 1) { ?>
			<img src="/databases/images/fulltext.gif" alt="Full Text" />
		<?php }?>
		<?php if ($dbInfo['trialDatabase'] == 1) { ?>
			<img src="/databases/images/trial.gif" alt="Trial" />
		<?php }?>
		<?php if ($dbInfo['newDatabase'] == 1) { ?>
			<img src="/databases/images/new.gif" alt="New" />
		<?php }?>
		</p>
	<?php }?>

	<?php
	if ($dbInfo['trialDatabase'] == 1) {
        print "<p><span class=\"trialText\">Trial ends on ".date("M d, Y",$dbInfo['trialExpireDate'])."</span></p>";
	}
	?>

	
    <?php if(!empty($dbInfo['description'])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">Description:</span>
		</div>

		<div class="infoKeyInfo">
			<?php
		         $description = preg_replace('/\n/','<br />',$dbInfo['description']);
				 print $description;
			?>
		</div>
	</div>
	<?php } ?>
		
    <?php if(!empty($dbInfo['yearsOfCoverage'])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">Years of Coverage:</span>
		</div>

		<div class="infoKeyInfo">
			<php print $dbInfo['yearsOfCoverage'] ?>
		</div>
	</div>
	<?php } ?>
		
    <?php if(!empty($dbInfo['updated'])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">Updated:</span>
		</div>

		<div class="infoKeyInfo">
			<?php 
			
			$sql = "SELECT * FROM updateText WHERE ID=".$dbInfo['updated'];
			$engineVars['openDB']->sanitize = FALSE;
			$sqlResult = $engineVars['openDB']->query($sql);

			if (!$sqlResult['result']) {
				print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
			}
			else {
				$updateInfo = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC);
			}
			
			print $updateInfo['name'];
			
			 ?>
		</div>
	</div>
	<?php } ?>
		
	
	<?php if(!empty($dbInfo['help'])) {?>
		
	<?php
	 
	$helps = explode("\n",$dbInfo['help']);
	$helpURL = explode("\n",$dbInfo['helpURL']);
	
	$help = "";
	for ($I=0;$I<count($helps);$I++) {
		if(!empty($helps[$I])) {
			if (!empty($helpURL[$I])) {
				$help .= "<a href=\"".$helpURL[$I]."\">";
			}
			$help .= $helps[$I];
			if (!empty($helpURL[$I])) {
				$help .= "</a>";
			}
			$help .= "<br />";
		}
	}
	
	?>
		
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">Help:</span>
		</div>

		<div class="infoKeyInfo">
			<?php print $help; ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if(!empty($dbInfo['access']) || !empty($dbInfo['accessType'])) {?>

	<?php

	$access = "";
	
	$sql = "SELECT * FROM accessTypes WHERE ID=".$dbInfo['accessType'];
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);

	if (!$sqlResult['result']) {
		print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
	}
	else {
		$temp   = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC);
		$access .= $temp['name'] ."<br /><br />";
	}


	$sql = "SELECT * FROM accessPlainText WHERE ID=".$dbInfo['access'];
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);

	if (!$sqlResult['result']) {
		print webHelper_errorMsg("SQL Error: ".$sqlResult['error']);
	}
	else {
		$temp   = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC);
		$access .= $temp['name'];
	}

	?>
		
		
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">Access:</span>
		</div>

		<div class="infoKeyInfo">
			<?php print $access; ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if(!empty($dbInfo[''])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">:</span>
		</div>

		<div class="infoKeyInfo">
			<?php print $dbInfo['']; ?>
		</div>
	</div>
	
	<?php } ?>
	
	<?php if(!empty($dbInfo[''])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">:</span>
		</div>

		<div class="infoKeyInfo">
			<?php print $dbInfo['']; ?>
		</div>
	</div>
	<?php } ?>
	
	
	<?php if(!empty($dbInfo[''])) {?>
	<div class="infoBlock">
		<div class="infoKey">
			<span class="boldText">:</span>
		</div>

		<div class="infoKeyInfo">
			<?php print $dbInfo['']; ?>
		</div>
	</div>
	<?php } ?>


</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>