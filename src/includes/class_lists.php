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
		foreach ($subjects as $subject=>$subjectInfo) {

			if ($count++ % ($totalSubjects/$divisions) == 0 && $div<$divisions ) {
				$output .= sprintf("%s<div class=\"subjectDiv\" id=\"subjectDiv_%s\">",
					($div > 0)?"</div>":"",
					$div++);
			}

			if (($curLetter = strtoupper($subject[0])) != $prevLetter) {

				$output     .= (!isnull($prevLetter))?"</ul>":"";
				$output     .= sprintf("<h4 class=\"subjectLetterHeading\">%s</h4>\n",$curLetter);
				$output     .= "<ul class=\"subjectDivList\">\n";
				$prevLetter  = $curLetter;
			}

			
				$output .= "<li>";
				$output .= sprintf('<a href="%s/subjects/?id=%s&status=%s">%s</a>',
					$localvars->get("databaseHome"),
					htmlentities($subjectInfo['ID']),
					status::current(),
					htmlentities($subject)
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
	

}

?>