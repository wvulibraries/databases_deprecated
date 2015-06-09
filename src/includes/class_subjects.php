<?php

class subjects {
	
	// if $ID is null, return all, otherwise, return ID
	// returns array
	public static function get($ID=NULL) {

		$localvars = localvars::getInstance();
		$db       = db::get($localvars->get('dbConnectionName'));

		if (!isnull($ID) && validate::integer($ID)) {
			$whereClause = sprintf("WHERE `ID`=%s", $ID);
		}
		else {
			$whereClause = "";
		}

		$sql       = sprintf("SELECT * FROM `subjects` %s ORDER BY `name`", $whereClause);
		$sqlResult = $db->query($sql);

		$subjects = array();
		while ($row = $sqlResult->fetch()) {
			$subjects[$row['name']] = array("ID" => $row['ID'], "URL" => $row['url'], "name"=>$row['name']);
		}

		return $subjects;

	}

}

?>