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

	public function get($id) {

		$sql = "SELECT * FROM dbList WHERE ID=?";
		$sqlResult = $this->db->query($sql,array($id));

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
			return FALSE;
		}	

		if ($sqlResult->rowCount() < 1) {
			return "";	
		}

		return $sqlResult->fetch();

	}

	public function getBySubject() {

		$sql       = sprintf("select * from dbList JOIN databases_subjects where databases_subjects.subjectID=? AND dbList.ID=databases_subjects.dbID AND (%s) AND `dbList`.`mobile`='0' AND `dbList`.`alumni`='0' ORDER BY dbList.name",
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql,array($_GET['MYSQL']['id']));

		if ($sqlResult->error()) {
			errorHandle::newError($sqlResult->errorMsg(), errorHandle::DEBUG);
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
	// $table is assumed to be sanitized before entry
	public function getMessage($table,$id,$field="name") {
		
		$sql       = sprintf("SELECT * FROM `%s` WHERE `ID`=?",$this->db->escape($table));
		$sqlResult = $this->db->query($sql,array($id));

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return "Error.";
		}

		$result = $sqlResult->fetch();
		return $result['name'];

	}
	public function getHelpList($database) {

		$helps   = explode("\n",$database['help']);
		$helpURL = explode("\n",$database['helpURL']);

		$output  = '<ul id="database_helpList">';

		for ($I=0;$I<count($helps);$I++) {
			if(!is_empty($helps[$I]) && !is_empty($helpURL[$I])) {
				$output .= sprintf('<a href="%s">%s</a>',
					htmlSanitize($helpURL[$I]),
					htmlSanitize($helps[$I])
					);
			}
		}

		$output .= "</ul>";

		return $output;

	}
}

?>