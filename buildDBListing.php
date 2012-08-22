<?php while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {?>
	
	<div class="dbListing">
		<p id="dbName"><a href="/databases/connect.php?<?= $row['URLID'] ?>=INVS"><?= str2TitleCase($row['name'])?></a></p>
	
		<?php if ($row['fullTextDB'] == 1 || $row['newDatabase'] == 1 || $row['trialDatabase'] == 1) { ?>
			<p id="fullTextRow">
			<?php if ($row['fullTextDB'] == 1) { ?>
				<img src="/databases/images/fulltext.gif" alt="Full Text" />
			<?php }?>
			<?php if ($row['trialDatabase'] == 1) { ?>
				<img src="/databases/images/trial.gif" alt="Trial" />
			<?php }?>
			<?php if ($row['newDatabase'] == 1) { ?>
				<img src="/databases/images/new.gif" alt="New" />
			<?php }?>
			</p>
		<?php }?>
		
		<?php if (!empty($row['description'])) {?>

			<p id="shortDesc">
				<?php
				if ($row['trialDatabase'] == 1) {
			        print "<span class=\"trialText\">Trial ends on ".date("M d, Y",$row['trialExpireDate'])." &ndash; </span>";
				}
				?>
				
				<?php 
			        list($shortDesc) = explode(".",$row['description']);
			        print $shortDesc."...."; 
				?>
			</p>

		<?php } ?>
		
		<p id="moreInfo">
			<a href="database.php?id=<?= (!empty($row['dbID']))?$row['dbID']:$row['ID']; ?>">(More Info)</a>
		</p>
		
		<hr noshade="noshade" size="1"/>
		
	</div>
	
<?php } ?>