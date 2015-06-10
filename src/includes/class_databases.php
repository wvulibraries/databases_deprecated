<?php

class databases {

	private static $approot = "/databases"; 

	private $localvars;
	private $engine;
	private $validate;
	private $db;

	function __construct() {
		$this->localvars = localvars::getInstance();
		$this->engine    = EngineAPI::singleton();
		$this->validate  = validate::getInstance();
		$this->db        = db::get($this->localvars->get('dbConnectionName'));
	}

	public function getBySubject() {

		$sql       = sprintf("select * from dbList JOIN databases_subjects where databases_subjects.subjectID=? AND dbList.ID=databases_subjects.dbID AND (%s) AND `dbList`.`mobile`='0' AND `dbList`.`alumni`='0' ORDER BY dbList.name",
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql,array($_GET['MYSQL']['id']));

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
			errorHandle::newError($sqlResult->sql(), errorHandle::DEBUG);
			return FALSE;
		}

		$databases = array();
		while($row = $sqlResult->fetch()) {
			$databases[] = $row;
		}

		return $databases;

	}

	public static function buildDBListing($sqlResult) {

		return lists::databases($sqlResult);

	}

	public function expireTrials() {
		
		$sql       = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<?";
		$sqlResult = $this->db->query($sql,array(time()));

		return TRUE;
	}
}

?>