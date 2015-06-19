<?php

class lists {
	
	public static function subjects() {

		$localvars = localvars::getInstance();

		// @todo do we want this to be static? would caching the results be 
		// benificial
		$subjects      = subjects::get();
		$totalSubjects = count($subjects);
		$divisions     = 2; // @TODO this needs to be configurable somewhere

		$prevLetter    = NULL;

		$output        = "";

		$count = 0;
		$div   = 0;
		foreach ($subjects as $subject) {

			if ($count++ % ($totalSubjects/$divisions) == 0 && $div<$divisions ) {
				$output .= sprintf("%s<div class=\"subjectDiv\" id=\"subjectDiv_%s\">",
					($div > 0)?"</div>":"",
					$div++);
			}

			if (($curLetter = strtoupper($subject['name'][0])) != $prevLetter) {

				$output     .= (!isnull($prevLetter))?"</ul>":"";
				$output     .= sprintf("<h4 class=\"subjectLetterHeading\">%s</h4>\n",$curLetter);
				$output     .= "<ul class=\"subjectDivList\">\n";
				$prevLetter  = $curLetter;
			}

			
				$output .= "<li>";
				$output .= sprintf('<a href="%s/subjects/?id=%s&status=%s">%s</a>',
					$localvars->get("databaseHome"),
					htmlentities($subject['ID']),
					status::current(),
					htmlentities($subject['name'])
					);
				$output .= "</li>\n";

				$count++;
			

		}
		$output .= "</div>"; // closes the last division

		return $output;

	}

	private static function helper_dbType($type) {

		return sprintf('<img src="%s/%s.gif" alt="Full Text" />',
			"/databases/images", // @TODO make configurable
			htmlSanitize($type),
			"gif" // @TODO make configurable
			);

	}

	// expects $databases to be a database array
	public static function databases($databases) {

		$localvars = localvars::getInstance();

		$output = "";

		foreach ($databases as $database) {

			$output .= '<div class="dbListing">';
			$output .= sprintf('<p id="dbName"><a href="%s?%s=INVS">%s</a></p>',
				$localvars->get("connectURL"),
				$database['URLID'],
				str2TitleCase($database['name'])
				);

			$output .= sprintf('<p id="fullTextRow"></p>',
				($database['fullTextDB']    == 1)?self::helper_dbType("fulltext"):"",
				($database['trialDatabase'] == 1)?self::helper_dbType("trial"):"",
				($database['newDatabase']   == 1)?self::helper_dbType("new"):""
				);

			$output .= '<p id="shortDesc">';
			if ($database['trialDatabase'] == 1) {
				$output .= sprintf('<span class="trialText">Trial ends on %s &ndash; </span>',
					date("M d, Y",$database['trialExpireDate'])
					);
			}
			$output .= ((!is_empty($database['description']) && list($shortDesc) = explode(".",$database['description']))?$shortDesc."....\n":"");
			$output .= '</p>';
	
			$output .= sprintf('<p id="moreInfo"><a href="%s/database/?id=%s">(More Info)</a></p>',
				$localvars->get("databaseHome"),
				(!empty($database['dbID']))?$database['dbID']:$database['ID']
				);

			$output .= '<hr noshade="noshade" size="1"/>';
			$output .= '</div>';

		}

		return $output;

	}

	public static function popular($databases) {

		$localvars = localvars::getInstance();

		$output = "<ul id=\"popularDBList\">";

		foreach ($databases as $database) {

			$output .= sprintf('<li><a href="%s?%s=INVS\">%s</a></li>',
				$localvars->get("connectURL"),
				$database['URLID'],
				htmlSanitize($database['name'])
				);

		}
		$output .= "</ul>";

		return $output;
	}

	// This method is largely unchanged from the previous function. It will likely be changed
	// as we work on the new design
	public static function letters() {

		$localvars = localvars::getInstance();
		$dbObject  = new databases;
		$databases = $dbObject->getAll();

		$sArray     = array();
		$countTotal = 0;
		foreach ($databases as $database) {

			$cfl = strtoupper($database['name'][0]);

			if(is_numeric($cfl)) {
				$cfl = "#";
			}

			$sArray[$cfl] = TRUE;

			$countTotal++;
		}

		$count = 0;

		$output = "<ul>";
		foreach ($sArray as $letter => $value) {

			if ($countTotal > 8 && $count++%8 == 0) {
				$output .= "</p><p class=\"dbLetterLine\">";
			}

			$output .= sprintf('<li><a href="%s/letter/?id=%s&%s">%s</a></li>',
				$localvars->get("databaseHome"),
				(($letter == "#")?"num":$letter),
				status::current(),
				$letter
				);

		}
		$output .= "</ul>";

		return $output;

	}

	public static function resourceTypes() {

		$localvars = localvars::getInstance();
		$db        = db::get($localvars->get('dbConnectionName'));

		$sql       = "SELECT * FROM resourceTypes ORDER BY name";
		$sqlResult = $db->query($sql);

		$count      = 0;
		$ul2        = FALSE;

		$output = "<ul class=\"rtUL\" id=\"rtUL1\">";

		while ($row = $sqlResult->fetch()) {

			if ($sqlResult->rowCount() > 8 && $count++ >= $sqlResult->rowCount()/2 && $ul2 == FALSE) {
				$output .= "</ul><ul class=\"rtUL\" id=\"rtUL2\">";
				$ul2     = TRUE;
			}

			$output .= sprintf('<li><a href="%s/resourceTypes/?id=%s&%s">%s</a></li>',
				$localvars->get("databaseHome"),
				$row['ID'],
				status::current(),
				$row['name']
				);

		}
		$output .= "</ul>";

		return($output);

	}

}

?>