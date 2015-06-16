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

	public function find($query) {

		$sql       = sprintf('SELECT * FROM `dbList` WHERE `name` LIKE "%%%s%%"',
			$query
			);
		$sqlResult = $this->db->query($sql);


		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return array();
		}	

		return $sqlResult->fetchAll();

	}

	public function get($id) {

		$sql = "SELECT * FROM dbList WHERE ID=?";
		$sqlResult = $this->db->query($sql,array($id));

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return FALSE;
		}	

		if ($sqlResult->rowCount() < 1) {
			return "";	
		}

		return $sqlResult->fetch();

	}

	public function getAll() {

		$sql       = sprintf("SELECT * FROM dbList WHERE %s ORDER BY name", status::buildSQLStatus());
		$sqlResult = $this->db->query($sql);

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return array();
		}	

		return $sqlResult->fetchAll();

	}

	public function getByURLID($urlID) {

		$sql      = "SELECT * FROM dbList WHERE URLID=?";
		$sqlResult = $this->db->query($sql,array($urlID));

		if ($sqlResult->rowCount() != 1) {
			print "Error with database selection.";
			break;
		}

		return $sqlResult->fetch();

	}

	public function getBySubject() {

		$sql       = sprintf("select * from dbList JOIN databases_subjects where databases_subjects.subjectID=? AND dbList.ID=databases_subjects.dbID AND (%s) AND `dbList`.`mobile`='0' AND `dbList`.`alumni`='0' ORDER BY dbList.name",
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql,array($_GET['MYSQL']['id']));

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return array();
		}

		return $sqlResult->fetchAll();

	}

	public function getByResourceType($resourceType) {

		$sql = sprintf('select * from dbList JOIN databases_resourceTypes where databases_resourceTypes.resourceID=? AND dbList.ID=databases_resourceTypes.dbID AND (%s) ORDER BY dbList.name',
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql,array($resourceType));

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return array();
		}

		return $sqlResult->fetchAll();

	}

	public function getByType($type) {

		$sql = sprintf("select * from dbList WHERE `%s`='1' AND (%s) ORDER BY name",
			$this->db->escape($type),
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql);

		if ($sqlResult->error()) {
			errorHandle::newError(__METHOD__."() - ".$sqlResult->errorMsg(), errorHandle::DEBUG);
			return array();
		}

		return $sqlResult->fetchAll();

	}

	public function getByLetter($letter) {

		if ($letter == "num") {
			$letter = "1' OR name REGEXP '^2' OR name REGEXP '^3' OR name REGEXP '^4' OR name REGEXP '^5' OR name REGEXP '^6' OR name REGEXP '^7' OR name REGEXP '^8' OR name REGEXP '^9' OR name REGEXP '^0";
		}

		$sql = sprintf("select * from dbList WHERE (name REGEXP '^%s') AND (%s) AND `mobile`='0' AND `alumni`='0' ORDER BY name",
			$letter,
			status::buildSQLStatus()
			);
		$sqlResult = $this->db->query($sql);
		
		return $sqlResult->fetchAll();

	}

	public function expireTrials() {
		
		$sql       = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<?";
		$sqlResult = $this->db->query($sql,array(time()));

		return TRUE;
	}

	public function buildLocalvars($database) {

		$this->localvars->set("database_name",$database['name']);
		$this->localvars->set("database_connection_url",sprintf("%s?%s=INVS",$this->localvars->get("connectURL"),$database['URLID']));
		$this->localvars->set("database_fullText",($database['fullTextDB']    == 1)?"":'<img src="/databases/images/fulltext.gif" alt="Full Text" />');
		$this->localvars->set("database_fullText",($database['trialDatabase'] == 1)?"":'<img src="/databases/images/trial.gif" alt="Trial" />');
		$this->localvars->set("database_fullText",($database['newDatabase']   == 1)?"":'<img src="/databases/images/new.gif" alt="New" />');

		$this->localvars->set("database_trialText_display", ($database['trialDatabase'] == 1)?"block":"none");
		$this->localvars->set("database_trialDate", date("M d, Y",$database['trialExpireDate']));

		$this->localvars->set("database_description_display", (is_empty($database['description']))?"none":"block");
		$this->localvars->set("database_description", preg_replace('/\n/','<br />',$database['description']));

		$this->localvars->set("database_yearsOdCoverage_display", (is_empty($database['yearsOfCoverage']))?"none":"block");
		$this->localvars->set("database_yearsOfCoverage",$database['yearsOfCoverage']);

		$this->localvars->set("database_updated_display", (is_empty($database['updated']) )?"none":"block");
		$this->localvars->set("database_updated",$this->getMessage("updateText",$database['updated']));

		$this->localvars->set("database_help_display",(is_empty($database['help']))?"none":"block");
		$this->localvars->set("database_help",$this->getHelpList($database));

		$this->localvars->set("database_access_display",(is_empty($database['access']) || is_empty($database['accessType']))?"none":"block");
		$this->localvars->set("database_access",$this->getAccessMessage($database));

	}

	public function getAccessMessage($database) {

		$accessType = $this->getMessage("accessTypes",$database['accessType']);
		$access     = $this->getMessage("accessPlainText",$database['access']);

		return sprintf('<p>%s</p><p>%s</p>',htmlSanitize($accessType),htmlSanitize($access));

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

	public function status($database,$html=TRUE) {

		switch($database['status']) {
			case 1:
				$class = "status_published";
				$status = "Published";
				break;
			case 2:
				$class = "status_development";
				$status = "Development";
				break;
			case 3:
				$class = "status_hidden";
				$status = "Hidden";
				break;
			default:
				$class = "status_error";
				$status = "Error";
		}

		if ($html) {
			$status = sprintf('<span class="%s">%s</span>',$class,$status);
		}

		return $status;

	}

}

?>