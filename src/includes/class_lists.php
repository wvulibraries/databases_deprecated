<?php

class lists {
	
	public static function subjects() {

		// @todo do we want this to be static? would caching the results be 
		// benificial
		$subjects      = subjects::getSubjects();
		$totalSubjects = count($subjects);
		$divisions     = 2; // @TODO this needs to be configurable somewhere

		$prevLetter    = NULL;

		$output        = "";

		foreach ($subjects as $subject) {

			if ($I % ($totalSubjects/$divisions) == 0 && $div<$divisions ) {
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

			
			foreach ($item as $subject) {
				$output .= "<li>";
				$output .= sprintf("<a href=\"subjects.php?id=%s&status=%s\">%s</a>",
					htmlentities($subject['ID']),
					status::current(),
					htmlentities($subject['name'])
					);
				$output .= "<a href=\"subjects.php?id=".htmlentities($subject['ID'])."$currentStatus\">".htmlentities($subject['name'])."</a>";
				$output .= "</li>\n";

				$count++;
			}
			$output .= "</ul>\n";

		}
		$output .= "</div>"; // closes the last division

	}

	return $output;

}

?>