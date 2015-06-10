<?php

class resourceTypes {

	public static function get($ID=NULL) {

		$localvars = localvars::getInstance();
		$db        = db::get($localvars->get('dbConnectionName'));
		$validate  = validate::getInstance();

		if (!isnull($ID) && $validate->integer($ID)) {
			$whereClause = sprintf("WHERE `ID`=%s", $ID);
		}
		else {
			$whereClause = "";
		}

		$sql       = sprintf("SELECT * FROM `resourceTypes` %s ORDER BY `name`", $whereClause);
		$sqlResult = $db->query($sql);

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
			return FALSE;
		}

		return $sqlResult->fetchAll();

	}

	
}

?>