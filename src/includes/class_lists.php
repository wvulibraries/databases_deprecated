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

		$output .= sprintf('<div class="subjectDiv" id="subjectDiv_0">');

		foreach ($subjects as $subject) {

			// if ($count++ % ($totalSubjects/$divisions) == 0 && $div<$divisions ) {
			// 	$output .= sprintf("%s<div class=\"subjectDiv\" id=\"subjectDiv_%s\">",
			// 		($div > 0)?"</div>":"",
			// 		$div++);
			// }

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

	private static function generateDBTags($database) {

		$localvars = localvars::getInstance();

		$output = "";

		foreach ($localvars->get("databaseTagTypes") as $I=>$V) {
			if ($database[$I]  == 1) {
				$output .= sprintf('<li><a href="#">%s</a></li>', $V);
			}
		}
		
		$dbObject  = new databases;


		$tags = array_merge($dbObject->subjects($database['dbID']),$dbObject->resourceTypes($database['dbID']));
		usort($tags,function($a,$b){return strcmp($a['name'], $b['name']);});

		foreach ($tags as $tag) {
			$output .= sprintf('<li><a href="#">%s</a></li>', $tag['name']);
		}

		return $output;
	}

	// expects $databases to be a database array
	public static function databases($databases) {

		$localvars = localvars::getInstance();

		$output = "";

		foreach ($databases as $database) {

			$output .= '<div class="database">';
			$output .= '<div class="database-box">';
			$output .= '<div class="database-box-top database-resize">';
			$output .= sprintf('<h3><a href="%s?%s=INVS">%s</a></h3>',
				$localvars->get("connectURL"),
				$database['URLID'],
				$database['name']
				);
			$output .= sprintf('<p>%s <span class="moreLink">[ <a href="%s/database/?id=%s">More Information</a> ]</span></p>',
				(!is_empty($database['description']))?substr($database['description'],0,$localvars->get("descriptionLength")):"",
				$localvars->get("databaseHome"),
				(!empty($database['dbID']))?$database['dbID']:$database['ID']
				);
			if ($database['trialDatabase'] == 1) {
				$output .= sprintf('<p class="trialText">Trial ends on %s &ndash; </p>',
					date("M d, Y",$database['trialExpireDate'])
					);
			}
			$output .= '</div>'; // database-box-top

			$output .= '<div class="database-box-bottom database-res">';
            $output .= '<ul class="database-box-bottom-tags">';
            $output .= self::generateDBTags($database);
            $output .= '</ul>';
            $output .= '</div>'; // database-box-bottom

			$output .= '</div>'; // database-box
			$output .= '</div>'; // database

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

			$output .= sprintf('<li><a href="%s/letter/?id=%s&status=%s">%s</a></li>',
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