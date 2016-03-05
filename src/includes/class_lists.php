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

				$output     .= (!isnull($prevLetter))?"</ul></div>":"";
				$output     .= sprintf("<div class='subres'><h3 class=\"subjectLetterHeading\">%s</h3>\n",$curLetter);
				$output     .= "<ul class=\"subjectDivList\">\n";
				$prevLetter  = $curLetter;
			}


				$output .= "<li>";
				$output .= sprintf('<a href="%s/subjects/subject/?id=%s&status=%s">%s</a>',
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
				$output .= sprintf('<li><a href="%s/type/%s/">%s</a></li>',
					$localvars->get('databaseHome'),
					strtolower($V),
					$V
					);
			}
		}

		$dbObject  = new databases;

		if (!isset($database['dbID'])) $database['dbID'] = $database['ID'];

		$tags = array_merge($dbObject->subjects($database['dbID']));
		usort($tags,function($a,$b){return strcmp($a['name'], $b['name']);});

		foreach ($tags as $tag) {

			$output .= sprintf('<li><a href="%s/%s/?id=%s">%s</a></li>',
				$localvars->get('databaseHome'),
				(isset($tag['resourceID']))?"resourceTypes":"subjects",
				(isset($tag['resourceID']))?$tag['resourceID']:$tag['subjectID'],
				$tag['name']
				);
		}

		return $output;
	}

	private static function generateClassTags($database) {

		$localvars = localvars::getInstance();
		$dbObject  = new databases;

		if (!isset($database['dbID'])) $database['dbID'] = $database['ID'];

		$tags = array_map(function($a){return $a['name'];},array_merge($dbObject->subjects($database['dbID']), $dbObject->resourceTypes($database['dbID'])));

		foreach ($localvars->get("databaseTagTypes") as $I=>$V) {
			if ($database[$I]  == 1) {
				$tags[] = $V;
			}
		}

		$tags = array_map(function($a){return str_replace(" ", "-", str_replace("&", "", $a));},$tags);

		return implode(" ",$tags);
	}

	// expects $databases to be a database array
	public static function databases($databases,$results_count=TRUE) {

		$localvars = localvars::getInstance();

		if ($results_count) $localvars->set("results_count",count($databases));

		$output = "";

		foreach ($databases as $database) {
			$output .= sprintf('<div class="database %s">',
				self::generateClassTags($database)
				);
			$output .= '<div class="database-box">';
			$output .= '<div class="database-box-top database-resize">';
			$output .= sprintf('<h3><a href="%s?%s=INVS" target="_blank">%s</a>',
				$localvars->get("connectURL"),
				$database['URLID'],
				$database['name']
				);

			// Print if a new database
			$output .= ($database['newDatabase'])?'<span class="new-database">(New)</span>':"";


			// print if a trial database
			$output .= ($database['trialDatabase'])?'<span class="trial-database">(Trial)</span>':"";

			$output .= '</h3>';

			$output .= sprintf('<p>%s</p>',
				(!is_empty($database['description']))?$database['description']:""
				);
			if ($database['trialDatabase'] == 1) {
				$output .= sprintf('<p class="trialText">Trial ends on %s &ndash; </p>',
					date("M d, Y",$database['trialExpireDate'])
					);
				$output .= sprintf('<a href="%sfeedback/?dbid=%s">Trial Database Feedback</a>',$localvars->get("siteRoot"),$database['ID']);
			}
			//$output .= '<span class="bookmark-false">Bookmark</span>';
			$output .= '</div>'; // database-box-top

			// $output .= '<div class="database-box-bottom database-res">';
   //          $output .= '<ul class="database-box-bottom-tags">';
   //          $output .= self::generateDBTags($database);
   //          $output .= '</ul>';
   //          $output .= '</div>'; // database-box-bottom

			$output .= '</div>'; // database-box
			$output .= '</div>'; // database

		}

		return $output;

	}

	public static function popular($databases) {

		return self::databases($databases,FALSE);

	}

	// This method is largely unchanged from the previous function. It will likely be changed as we work on the new design
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

		$output = "<div style='clear:both;'></div><ul class='a2z'>";
		foreach ($sArray as $letter => $value) {

			$output .= sprintf('<li><a href="%s/AtoZ/?id=%s&status=%s">%s</a></li>',
				$localvars->get("databaseHome"),
				(($letter == "#")?"num":$letter),
				status::current(),
				$letter
				);

		}
		$output .= "</ul><div style='clear:both;'></div>";

		return $output;

	}

	public static function resourceTypes() {

		$localvars = localvars::getInstance();
		$db        = db::get($localvars->get('dbConnectionName'));

		$resourceTypes = resourceTypes::get();

		$output = "<ul>";

		foreach ($resourceTypes as $row) {

			$output .= sprintf('<li data-breadcrumb="%s" class="%s"><a href="%s/resourceTypes/?id=%s&%s">%s</a><i class="fa fa-angle-right"></i></li>',
				str_replace(" ", "-", $row['name']),
				$localvars->get("enableBreadcrumbClicking"),
				$localvars->get("databaseHome"),
				$row['ID'],
				status::build(),
				$row['name']
				);

		}
		$output .= "</ul>";

		return($output);

	}

}

?>
