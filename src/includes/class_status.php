<?php

class status {

	public static function set() {

		$localvars = localvars::getInstance();

		if(isset($_GET['HTML']['status']) && !is_empty($_GET['HTML']['status']) && isint($_GET['HTML']['status'])) {
			$localvars->set("status",$_GET['HTML']['status']);
		}
		else {
			$localvars->set("status",1);
		}

		return TRUE;
	}

	public static function current() {

		if (isset($_GET['HTML']['status']) && !is_empty($_GET['HTML']['status'])) {
			return $_GET['HTML']['status'];
		}

		return "";

	}

	public static function buildSQLStatus() {

		$status    = self::current();
		$localvars = localvars::getInstance();

		switch($status) {
			case "1":
			case "published":
				$status = "dbList.status='1'";
				break;
			case "2":
			case "development":
				$status = "dbList.status='1' OR dbList.status='2'";
				break;
			case "3":
			case "hidden":
				$status = "dbList.status='3'";
				break;
			case "4":
			case "all":
				$status = "dbList.status='1' OR dbList.status='2' OR dbList.status='3'";
				break;
			default:
				$status = "";
		}

		return $status;

	}

	public static function build() {

		$status = self::current();

		return (is_empty($status))?"":"status=".htmlSanitize($status);

	}

}

?>