<?php

class databases {

	private static $approot = "/databases"; 

	private $localvars;
	private $engine;
	private $db;

	function __construct() {
		$this->localvars = localvars::getInstance();
		$this->engine    = EngineAPI::singleton();
		$this->db        = db::get($this->localvars->get('dbConnectionName'));
	}

	public static function buildDBListing($sqlResult) {

		$output = "";

		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_ASSOC)) {

			$output .= '<div class="dbListing">';
			$output .= sprintf('<p id="dbName"><a href="/databases/connect.php?%s=INVS">%s</a></p>',
				$row['URLID'],
				str2TitleCase($row['name'])
				);

			if ($row['fullTextDB'] == 1 || $row['newDatabase'] == 1 || $row['trialDatabase'] == 1) {
				$output .= '<p id="fullTextRow">';
				if ($row['fullTextDB'] == 1) {
					$output .= '<img src="/databases/images/fulltext.gif" alt="Full Text" />';
				}
				if ($row['trialDatabase'] == 1) {
					$output .= '<img src="/databases/images/trial.gif" alt="Trial" />';
				}
				if ($row['newDatabase'] == 1) {
					$output .= '<img src="/databases/images/new.gif" alt="New" />';
				}
				$output .= '</p>';
			}

			if (!empty($row['description'])) {

				$output .= '<p id="shortDesc">';
				
				if ($row['trialDatabase'] == 1) {
					$output .= "<span class=\"trialText\">Trial ends on ".date("M d, Y",$row['trialExpireDate'])." &ndash; </span>";
				}
				
				list($shortDesc) = explode(".",$row['description']);
				$output .= $shortDesc."...."; 

				$output .= "</p>";

			} 

			$output .= '<p id="moreInfo">';
			$output .= sprintf('<a href="%s/database.php?id=%s">(More Info)</a>',
				self::$approot,
				(!empty($row['dbID']))?$row['dbID']:$row['ID']
				);
			$output .= '</p>';

			$output .= '<hr noshade="noshade" size="1"/>';

			$output .= '</div>';

		}

		return $output;
	}

	public function expireTrials() {
		
		$sql       = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<?";
		$sqlResult = $this->db->query($sql,array(time()));

		return TRUE;
	}
}

?>