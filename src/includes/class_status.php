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


}

?>