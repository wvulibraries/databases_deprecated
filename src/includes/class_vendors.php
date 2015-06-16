<?php

class vendors {
	
	public static function get($ID) {

		$localvars = localvars::getInstance();
		$db              = db::get($localvars->get('dbConnectionName'));

		$sql       = "SELECT * FROM `vendors` WHERE `ID`=?";
		$sqlResult = $db->query($sql,array($ID));

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
			return FALSE;
		}

		return $sqlResult->fetch();

	}

}

?>