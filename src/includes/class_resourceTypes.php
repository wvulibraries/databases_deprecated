<?php

class resourceTypes {

	public static function get($ID=NULL) {

		$localvars = localvars::getInstance();
		$db        = db::get($localvars->get('dbConnectionName'));
		$validate  = validate::getInstance();

		if (!isnull($ID) && $validate->integer($ID)) {
			$whereClause = sprintf("AND `resourceTypes`.`ID`=%s", $ID);
		}
		else {
			$whereClause = "";
		}

		$sql       = sprintf("SELECT `resourceTypes`.* FROM `resourceTypes` LEFT JOIN `databases_resourceTypes` ON `databases_resourceTypes`.`resourceID`=`resourceTypes`.`ID` LEFT JOIN `dbList` ON `dbList`.`ID`=`databases_resourceTypes`.`dbID` WHERE %s %s ORDER BY `name`", 
			status::buildSQLStatus(), 
			$whereClause);
		$sqlResult = $db->query($sql);

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
			return FALSE;
		}

		return $sqlResult->fetchAll();

	}

	
}

?>