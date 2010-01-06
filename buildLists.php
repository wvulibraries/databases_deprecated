<?php

function buildSubjectList() {
	
	global $engineVars;
	global $cleanGet;
	
	$currentStatus = (empty($cleanGet['HTML']['status']))?"":"&amp;status=".$cleanGet['HTML']['status'];
	
	$sql = "SELECT * FROM subjects ORDER BY name";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	$sArray = array();
	
	$countTotal = mysql_num_rows($sqlResult['result']);
	
	while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
		
		$cfl = strtoupper($row[1][0]);
		
		$sArray[$cfl][$row[0]]['ID'] = $row[0];
		$sArray[$cfl][$row[0]]['name'] = $row[1];
		
		//$countTotal++;
	}
	
	$div2    = FALSE;
	$count   = 0;
	
	$output = "<div class=\"subjectDiv\" id=\"subjectDiv1\">";
	foreach ($sArray as $letter => $item) {
		
		if ($count >= $countTotal/2 && $div2 == FALSE) {
			$output .= "</div><div class=\"subjectDiv\" id=\"subjectDiv2\">";
			$div2 = TRUE;
		}
		
		$output .= "<h4 class=\"subjectLetterHeading\">$letter</h4>\n";
		$output .= "<ul class=\"subjectDivList\">\n";
		foreach ($item as $subject) {
			$output .= "<li>";
			$output .= "<a href=\"subjects.php?id=".$subject['ID']."$currentStatus\">".htmlentities($subject['name'])."</a>";
			$output .= "</li>\n";
			
			$count++;
		}
		$output .= "</ul>\n";

	}
	$output .= "</div>";
	
	return($output);
	
}

function buildPopularDB() {
	
	global $engineVars;
	
	$sql = "SELECT * FROM dbList WHERE popular='1' ORDER BY name";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	$sArray = array();
	
	$output = "<ul id=\"popularDBList\">";
	while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_BOTH)) {
		
		$output .= "<li><a href=\"/databases/connect.php?".$row['URLID']."=INVS\">".htmlentities($row[1])."</a></li>";
		
	}
	$output .= "</ul>";
	
	return($output);
	
}

function buildTitleLetter() {
	
	global $engineVars;
	global $localVars;
	global $cleanGet;
	
	$currentStatus = (empty($cleanGet['HTML']['status']))?"":"&amp;status=".$cleanGet['HTML']['status'];
	
	$status = "";
	switch((!empty($localVars['status']))?$localVars['status']:"") {
		case 1:
		case "published":
		    $status = "WHERE status='1'";
		    break;
		case 2:
		case "development":
		    $status = "WHERE status='1' OR status='2'";
		    break;
		case 3:
		case "hidden":
		    $status = "WHERE status='3'";
		    break;
		case 4:
		case "all":
		    $status = "WHERE status='1' OR status='2' OR status='3'";
		    break;
		default:
		    $status = "";
	}
	
	$sql = "SELECT * FROM dbList ".$status." ORDER BY name";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	$sArray = array();
	
	$countTotal = 0;
	while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
		
		$cfl = strtoupper($row[1][0]);

		if(is_numeric($cfl)) {
			$cfl = "#";
		}

		$sArray[$cfl] = TRUE;
		
		$countTotal++;
	}
	
	$count = 0;
	
	$output = "<div id=\"letterLineDiv\">";
	$output .= "<p class=\"dbLetterLine\">";
	foreach ($sArray as $letter => $value) {
		
		if ($countTotal > 8 && $count++%8 == 0) {
			$output .= "</p><p class=\"dbLetterLine\">";
		}
		
		$output .= "<span class=\"dbLetter\"><a href=\"letter.php?id=".(($letter == "#")?"num":$letter)."$currentStatus\">$letter</a></span>";

	}
	$output .= "</p>";
	$output .= "</div>";
	
	return($output);
	
}

function buildResourceTypes() {
	
	global $engineVars;
	global $cleanGet;
	
	$currentStatus = (empty($cleanGet['HTML']['status']))?"":"&amp;status=".$cleanGet['HTML']['status'];
	
	$sql = "SELECT * FROM resourceTypes ORDER BY name";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	$countTotal = mysql_num_rows($sqlResult['result']);
	$count      = 0;
	$ul2        = FALSE;
	
	$output  = "<div id=\"resourceTypesULDiv\" class=\"clearfix\">";
	$output .= "<ul class=\"rtUL\" id=\"rtUL1\">";
	
	while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
		
		if ($countTotal > 8 && $count++ >= $countTotal/2 && $ul2 == FALSE) {
			$output .= "</ul><ul class=\"rtUL\" id=\"rtUL2\">";
			$ul2 = TRUE;
		}
		
		$output .= "<li><a href=\"resourcetype.php?id=".$row[0]."$currentStatus\">".htmlentities($row[1])."</a></li>";
		
	}
	$output .= "</ul>";
	$output .= "</div>";

	return($output);
	
}

function buildNews() {
	
	global $engineVars;
	
	$sql = "SELECT * FROM news ORDER BY ID DESC LIMIT 5";
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	$output = "<ul id=\"newsUL\">";
	
	while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
		
		$newsText = htmlentities($row[1]);
		//$newsText = wordwrap($newsText, 32, "<br />\n", true);
		
		$newsText = str_replace('\"','&quot;',$newsText);
		$newsText = str_replace('\&quot;','&quot;',$newsText);
		
		$output .= "<li>".$newsText."</li>";
		
	}
	$output .= "</ul>";
	
	return($output);
}

?>