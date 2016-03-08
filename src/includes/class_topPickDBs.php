<?php

class topPickDBs {
	
	public static function getTopPicksForSubject($id) {
		
		$localvars = localvars::getInstance();

		$db        = db::get($localvars->get('dbConnectionName'));
		$sql       = "SELECT `dbID` FROM `databases_curated` LEFT JOIN `dbList` ON `dbList`.`ID`=`databases_curated`.`dbID` WHERE subjectID=? ORDER BY `sort`,`dbList`.`name`";
		$sqlResult = $db->query($sql,array($id));

		$databases = array();
		$dbObject  = new databases;

		while($row = $sqlResult->fetch()) {

			$databases[] = $dbObject->get($row['dbID']);

		}

		return $databases;

	}	

}

?>