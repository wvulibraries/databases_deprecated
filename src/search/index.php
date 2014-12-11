<?php

require_once("/home/library/public_html/includes/engineHeader.php");

require "../includes/databases.php";

$engine->localVars('pageTitle',"WVU Libraries: Databases");
$engine->eTemplate("load","library2012.2col.right");

recurseInsert("dbTables.php","php");
require("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

recurseInsert("buildLists.php","php");

// Check for and expire trial databases
$sql = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<".time();
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);
//

$localVars['status'] = 1;
if(!empty($engine->cleanGet['HTML']['status']) && isint($engine->cleanGet['HTML']['status'])) {
	$localVars['status'] = $engine->cleanGet['HTML']['status'];
}

$engine->cleanGet['MYSQL']['q'] = urldecode($engine->cleanGet['MYSQL']['q']);
$engine->cleanGet['MYSQL']['q'] = str_replace("&", "&amp;", $engine->cleanGet['MYSQL']['q']);

$sqlResult = array();
if ($engine->cleanGet['MYSQL']['q'] && !isempty($engine->cleanGet['MYSQL']['q'])) {
	$sql       = sprintf('SELECT * FROM `dbList` WHERE `name` LIKE "%%%s%%"',
		$engine->cleanGet['MYSQL']['q']
	);
	$sqlResult = $engineVars['openDB']->query($sql);

}

$result = databases::buildDBListing($sqlResult);

if (is_empty($result)) {
	$result = sprintf('<br /><br />We do not have any databases named "<strong>%s</strong>".  Please browse our <a href="%s">Databases</a> by subject or title.',
		$engine->cleanGet['HTML']['q'],
		"/databases"
		);
}

// Fire up the Engine
$engine->eTemplate("include","header");

?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>Database Search Results</h3>

<?php print $result ?>
</div>

<div id="rightNav">

<?php recurseInsert("rightNav.php","php"); ?>

</div>
<!-- Page Content Goes Above This Line -->

<?php
$engine->eTemplate("include","footer");
?>