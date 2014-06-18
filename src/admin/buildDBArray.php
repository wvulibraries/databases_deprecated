<?php

function buildDBArray($data) {
	
	global $engineVars;
	global $engine;
	
	
	// echo "<pre>";
	// var_dump($data);
	// echo "</pre>";
	
	
	if(is_array($data) && isset($data['HTML'])) {
		
		//Build Trial Time
		$trialExpireDate = time();
		if(!empty($data['HTML']['trialDB'])) {
			$month = $data['HTML']['trialExpireDate_month'];
			$day   = $data['HTML']['trialExpireDate_day'];
			$year  = $data['HTML']['trialExpireDate_year'];
			
			$trialExpireDate              = mktime(0,0,0,$month,$day,$year);
		}
		$engine->localVars('trialExpireDate', $trialExpireDate);
		
		// Create and Update Dates
		$engine->localVars('updateDate', time());
		
		//Text Input
		$engine->localVars('dbName', (!empty($data['HTML']['dbName']))?$data['HTML']['dbName']:"");
		$engine->localVars('dbURL', (!empty($data['MYSQL']['dbURL']))?$data['MYSQL']['dbURL']:"");
		$engine->localVars('dbURLOffCampus', (!empty($data['MYSQL']['dbURLOffCampus']))?$data['MYSQL']['dbURLOffCampus']:"");
		$engine->localVars('yearsOfCoverage', (!empty($data['HTML']['yearsOfCoverage']))?$data['HTML']['yearsOfCoverage']:"");

		//Text Area
		$engine->localVars('helpText', (!empty($data['HTML']['helpText']))?$data['HTML']['helpText']:"");
		$engine->localVars('helpURL', (!empty($data['HTML']['helpURL']))?$data['HTML']['helpURL']:"");
		$engine->localVars('dbDesc', (!empty($data['HTML']['dbDesc']))?$data['HTML']['dbDesc']:"");

		//Single Check Boxes
		$engine->localVars('fullTextDB', (!empty($data['HTML']['fullTextDB']))?"checked=\"checked\"":"");
		$engine->localVars('newDB', (!empty($data['HTML']['newDB']))?"checked=\"checked\"":"");
		$engine->localVars('trialDB', (!empty($data['HTML']['trialDB']))?"checked=\"checked\"":"");
		$engine->localVars('popular', (!empty($data['HTML']['popular']))?"checked=\"checked\"":"");
		$engine->localVars('alumniDB',(!empty($data['HTML']['alumniDB']))?"checked=\"checked\"":"");

		//Drop down, managed
		$engine->localVars('dbStatus', (!empty($data['HTML']['dbStatus']))?buildECMSArray($data['HTML']['dbStatus']):"");
		$engine->localVars('vendors', (!empty($data['HTML']['vendors']))?buildECMSArray($data['HTML']['vendors']):"");
		$engine->localVars('updateText', (!empty($data['HTML']['updateText']))?buildECMSArray($data['HTML']['updateText']):"");
		$engine->localVars('accessType', (!empty($data['HTML']['accessType']))?buildECMSArray($data['HTML']['accessType']):"");
		$engine->localVars('accessPlainText', (!empty($data['HTML']['accessPlainText']))?buildECMSArray($data['HTML']['accessPlainText']):"");

		// Multi Check Boxes
		$engine->localVars('resourceTypes', (!empty($data['HTML']['resourceTypes']))?buildECMSArray($data['HTML']['resourceTypes']):"");
		$engine->localVars('subjects', (!empty($data['HTML']['subjects']))?buildECMSArray($data['HTML']['subjects']):"");


		//Drop Down, unmanaged
		//$engine->localVars('dbStatus', (!empty($data['HTML']['dbStatus'])?$data['HTML']['dbStatus']:""));
		
	}
	else {
		
		$engine->localVars('trialExpireDate', (!empty($data[20]))?$data[20]:time());

		$engine->localVars('dbName', (!empty($data[1]))?$data[1]:"");
		$engine->localVars('dbURL', (!empty($data[5]))?$data[5]:"");
		$engine->localVars('dbURLOffCampus', (!empty($data[6]))?$data[6]:"");
		$engine->localVars('yearsOfCoverage', (!empty($data[3]))?$data[3]:"");

		//Text Area
		$engine->localVars('helpText', (!empty($data[13]))?$data[13]:"");
		$engine->localVars('helpURL', (!empty($data[14]))?$data[14]:"");
		$engine->localVars('dbDesc', (!empty($data[15]))?$data[15]:"");
		
		// Create and Update Dates
		$engine->localVars('createDate', (!empty($data[16]))?$data[16]:"");
		$engine->localVars('updateDate', (!empty($data[17]))?$data[17]:"");

		//Single Check Boxes
		$engine->localVars('fullTextDB', (!empty($data[9]) && $data[9] == "1")?"checked=\"checked\"":"");
		$engine->localVars('newDB', (!empty($data[10]) && $data[10] == "1")?"checked=\"checked\"":"");
		$engine->localVars('trialDB', (!empty($data[11]) && $data[11] == "1")?"checked=\"checked\"":"");
		$engine->localVars('popular', (!empty($data[19]) && $data[19] == "1")?"checked=\"checked\"":"");
		$engine->localVars('alumniDB', (!empty($data[21]) && $data[21] == "1")?"checked=\"checked\"":"");

		//Drop down, managed
		$engine->localVars('dbStatus', (!empty($data[2]))?$data[2]:"");
		$engine->localVars('vendors', (!empty($data[4]))?$data[4]:"");
		$engine->localVars('updateText', (!empty($data[7]))?$data[7]:"");
		$engine->localVars('accessType', (!empty($data[8]))?$data[8]:"");
		$engine->localVars('accessPlainText', (!empty($data[12]))?$data[12]:"");

		// Multi Check Boxes
		$sql = sprintf("SELECT * from databases_subjects WHERE dbID=%s",
			$engine->openDB->escape($engine->localVars('dbID'))
			);
		$engine->openDB->sanitize = FALSE;
		$sqlResult = $engine->openDB->query($sql);
		
		$subjects = array();
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
			$subjects[] = $row[2];
		}
		
		$sql = sprintf("SELECT * from databases_resourceTypes WHERE dbID=%s",
			$engine->openDB->escape($engine->localVars('dbID'))
			);
		$engine->openDB->sanitize = FALSE;
		$sqlResult = $engine->openDB->query($sql);
		
		$resourceTypes = array();
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
			$resourceTypes[] = $row[2];
		}
		
		$engine->localVars('resourceTypes', (!empty($resourceTypes))?buildECMSArray($resourceTypes):"");
		$engine->localVars('subjects', (!empty($subjects))?buildECMSArray($subjects):"");

		//Drop Down, unmanaged
		//$engine->localVars('dbStatus', (!empty($data['HTML']['dbStatus'])?$data['HTML']['dbStatus']:""));
	}
	
	return(TRUE);
	
}

?>