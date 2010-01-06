<?php

function buildDBArray($data) {
	
	global $localVars;
	global $engineVars;
	
	/*
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	*/
	
	if(is_array($data) && isset($data['HTML'])) {
		
		//Build Trial Time
		$trialExpireDate = time();
		if(!empty($data['HTML']['trialDB'])) {
			$month = $data['HTML']['trialExpireDate_month'];
			$day   = $data['HTML']['trialExpireDate_day'];
			$year  = $data['HTML']['trialExpireDate_year'];
			
			$trialExpireDate              = mktime(0,0,0,$month,$day,$year);
		}
		$localVars['trialExpireDate'] = $trialExpireDate;
		
		// Create and Update Dates
		$localVars['updateDate'] = time();
		
		//Text Input
		$localVars['dbName']          = (!empty($data['HTML']['dbName']))?$data['HTML']['dbName']:"";
		$localVars['dbURL']           = (!empty($data['MYSQL']['dbURL']))?$data['MYSQL']['dbURL']:"";
		$localVars['dbURLOffCampus']  = (!empty($data['MYSQL']['dbURLOffCampus']))?$data['MYSQL']['dbURLOffCampus']:"";
		$localVars['yearsOfCoverage'] = (!empty($data['HTML']['yearsOfCoverage']))?$data['HTML']['yearsOfCoverage']:"";

		//Text Area
		$localVars['helpText'] = (!empty($data['HTML']['helpText']))?$data['HTML']['helpText']:"";
		$localVars['helpURL']  = (!empty($data['HTML']['helpURL']))?$data['HTML']['helpURL']:"";
		$localVars['dbDesc']   = (!empty($data['HTML']['dbDesc']))?$data['HTML']['dbDesc']:"";

		//Single Check Boxes
		$localVars['fullTextDB'] = (!empty($data['HTML']['fullTextDB']))?"checked=\"checked\"":"";
		$localVars['newDB']      = (!empty($data['HTML']['newDB']))?"checked=\"checked\"":"";
		$localVars['trialDB']    = (!empty($data['HTML']['trialDB']))?"checked=\"checked\"":"";
		$localVars['popular']    = (!empty($data['HTML']['popular']))?"checked=\"checked\"":"";

		//Drop down, managed
		$localVars['dbStatus']        = (!empty($data['HTML']['dbStatus']))?buildECMSArray($data['HTML']['dbStatus']):"";
		$localVars['vendors']         = (!empty($data['HTML']['vendors']))?buildECMSArray($data['HTML']['vendors']):"";
		$localVars['updateText']      = (!empty($data['HTML']['updateText']))?buildECMSArray($data['HTML']['updateText']):"";
		$localVars['accessType']      = (!empty($data['HTML']['accessType']))?buildECMSArray($data['HTML']['accessType']):"";
		$localVars['accessPlainText'] = (!empty($data['HTML']['accessPlainText']))?buildECMSArray($data['HTML']['accessPlainText']):"";

		// Multi Check Boxes
		$localVars['resourceTypes'] = (!empty($data['HTML']['resourceTypes']))?buildECMSArray($data['HTML']['resourceTypes']):"";
		$localVars['subjects']      = (!empty($data['HTML']['subjects']))?buildECMSArray($data['HTML']['subjects']):"";


		//Drop Down, unmanaged
		//$localVars['dbStatus'] = (!empty($data['HTML']['dbStatus'])?$data['HTML']['dbStatus']:"");
		
	}
	else {
		
		$localVars['trialExpireDate'] = (!empty($data[20]))?$data[20]:time();

		$localVars['dbName']          = (!empty($data[1]))?$data[1]:"";
		$localVars['dbURL']           = (!empty($data[5]))?$data[5]:"";
		$localVars['dbURLOffCampus']  = (!empty($data[6]))?$data[6]:"";
		$localVars['yearsOfCoverage'] = (!empty($data[3]))?$data[3]:"";

		//Text Area
		$localVars['helpText'] = (!empty($data[13]))?$data[13]:"";
		$localVars['helpURL']  = (!empty($data[14]))?$data[14]:"";
		$localVars['dbDesc']   = (!empty($data[15]))?$data[15]:"";
		
		// Create and Update Dates
		$localVars['createDate'] = (!empty($data[16]))?$data[16]:"";
		$localVars['updateDate'] = (!empty($data[17]))?$data[17]:"";

		//Single Check Boxes
		$localVars['fullTextDB'] = (!empty($data[9]) && $data[9] == "1")?"checked=\"checked\"":"";
		$localVars['newDB']      = (!empty($data[10]) && $data[10] == "1")?"checked=\"checked\"":"";
		$localVars['trialDB']    = (!empty($data[11]) && $data[11] == "1")?"checked=\"checked\"":"";
		$localVars['popular']    = (!empty($data[19]) && $data[19] == "1")?"checked=\"checked\"":"";

		//Drop down, managed
		$localVars['dbStatus']        = (!empty($data[2]))?$data[2]:"";
		$localVars['vendors']         = (!empty($data[4]))?$data[4]:"";
		$localVars['updateText']      = (!empty($data[7]))?$data[7]:"";
		$localVars['accessType']      = (!empty($data[8]))?$data[8]:"";
		$localVars['accessPlainText'] = (!empty($data[12]))?$data[12]:"";

		// Multi Check Boxes
		$sql = sprintf("SELECT * from databases_subjects WHERE dbID=%s",
			$engineVars['openDB']->escape($localVars['dbID'])
			);
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		$subjects = array();
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
			$subjects[] = $row[2];
		}
		
		$sql = sprintf("SELECT * from databases_resourceTypes WHERE dbID=%s",
			$engineVars['openDB']->escape($localVars['dbID'])
			);
		$engineVars['openDB']->sanitize = FALSE;
		$sqlResult = $engineVars['openDB']->query($sql);
		
		$resourceTypes = array();
		while ($row = mysql_fetch_array($sqlResult['result'], MYSQL_NUM)) {
			$resourceTypes[] = $row[2];
		}
		
		$localVars['resourceTypes'] = (!empty($resourceTypes))?buildECMSArray($resourceTypes):"";
		$localVars['subjects']      = (!empty($subjects))?buildECMSArray($subjects):"";

		//Drop Down, unmanaged
		//$localVars['dbStatus'] = (!empty($data['HTML']['dbStatus'])?$data['HTML']['dbStatus']:"");
	}
	
	return(TRUE);
	
}

?>