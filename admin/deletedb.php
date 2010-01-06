<?php

global $cleanPost;
global $localVars;
global $dbTables;

if (isset($cleanPost['MYSQL']['deleteDB']) && isset($cleanPost['MYSQL']['id'])) {
	$sql = sprintf("DELETE FROM %s WHERE ID=%s", $dbTables['databases']['prod'], $cleanPost['MYSQL']['id']);
	
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);

}
?>
