<?php

global $engine;

$dbTables = $engine->dbTablesExport();

if (isset($engine->cleanPost['MYSQL']['deleteDB']) && isset($engine->cleanPost['MYSQL']['id'])) {
	$sql = sprintf("DELETE FROM %s WHERE ID=%s", $dbTables['databases']['prod'], $engine->cleanPost['MYSQL']['id']);
	
	$engine->openDB->sanitize = FALSE;
	$sqlResult = $engine->openDB->query($sql);

}
?>
