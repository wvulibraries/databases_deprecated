<?php

class subjects {
	
	// if $ID is null, return all, otherwise, return ID
	// returns array
	public static function get($ID=NULL) {

		$localvars = localvars::getInstance();
		$db        = db::get($localvars->get('dbConnectionName'));
		$validate  = validate::getInstance();

		if (!isnull($ID) && $validate->integer($ID)) {
			$whereClause = sprintf("AND `subjects`.`ID`=%s", $ID);
		}
		else {
			$whereClause = "";
		}

		$sql       = sprintf("SELECT DISTINCT `subjects`.* FROM `subjects` LEFT JOIN `databases_subjects` ON `databases_subjects`.`subjectID`=`subjects`.`ID` LEFT JOIN `dbList` ON `dbList`.`ID`=`databases_subjects`.`dbID` WHERE %s %s ORDER BY `name`", 
			status::buildSQLStatus(), 
			$whereClause);
		$sqlResult = $db->query($sql);

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sql, errorHandle::DEBUG);
			return FALSE;
		}

		return $sqlResult->fetchAll();

	}

}

?>