<?php

global $cleanPost;
global $localVars;
global $dbTables;

$error   = "";

buildDBArray($cleanPost);

if (empty($cleanPost['MYSQL']['dbName'])) {
	$error .= webHelper_errorMsg("Database Name is Required.");
}
if (empty($cleanPost['MYSQL']['dbURL'])) {
	$error .= webHelper_errorMsg("Database URL is Required.");
}
if (isnull($cleanPost['MYSQL']['dbStatus'])) {
	$error .= webHelper_errorMsg("Database Status is Required.");
}

if (!empty($error)) {
	print $error; 
}
else {
		
	/*
	echo "<pre>";
	var_dump($localVars);
	echo "</pre>";
	*/
		
	$dbID = $cleanPost['MYSQL']['newEntry'];
	$localVars['dbID'] = $dbID;
		
	$localtime = time();
	$updateDate = $localtime;
	$createDate = $localtime;
	
	$error = FALSE;
	
	$sql = "";
	if ($cleanPost['MYSQL']['newEntry'] == "null") {
		$sql = sprintf("INSERT INTO %s (name,status,yearsOfCoverage,vendor,url,offCampusURL,updated,accessType,fullTextDB,newDatabase,trialDatabase,access,help,helpURL,description,createDate,updateDate,URLID,popular,trialExpireDate) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$dbTables['databases']['prod'],
			$engineVars['openDB']->escape($localVars['dbName']),
			$engineVars['openDB']->escape($localVars['dbStatus']),
			$engineVars['openDB']->escape($localVars['yearsOfCoverage']),
			$engineVars['openDB']->escape($localVars['vendors']),
			$localVars['dbURL'],
			$localVars['dbURLOffCampus'],
			$engineVars['openDB']->escape($localVars['updateText']),
			$engineVars['openDB']->escape($localVars['accessType']),
			(empty($localVars['fullTextDB'])?"0":"1"),
			(empty($localVars['newDB'])?"0":"1"),
			(empty($localVars['trialDB'])?"0":"1"),
			$engineVars['openDB']->escape($localVars['accessPlainText']),
			$engineVars['openDB']->escape($localVars['helpText']),
			$engineVars['openDB']->escape($localVars['helpURL']),
			$engineVars['openDB']->escape($localVars['dbDesc']),
			$engineVars['openDB']->escape($createDate),
			$engineVars['openDB']->escape($updateDate),
			$engineVars['openDB']->escape($localtime),
			(empty($localVars['popular'])?"0":"1"),
			$localVars['trialExpireDate']
			);
	}
	else {
		$sql = sprintf("UPDATE %s SET name='%s', status='%s', yearsOfCoverage='%s', vendor='%s', url='%s', offCampusURL='%s', updated='%s', accessType='%s', fullTextDB='%s', newDatabase='%s', trialDatabase='%s', access='%s', help='%s', helpURL='%s', description='%s', updateDate='%s', popular='%s', trialExpireDate='%s' WHERE ID=%s",
		$dbTables['databases']['prod'],
		$engineVars['openDB']->escape($localVars['dbName']),
		$engineVars['openDB']->escape($localVars['dbStatus']),
		$engineVars['openDB']->escape($localVars['yearsOfCoverage']),
		$engineVars['openDB']->escape($localVars['vendors']),
		$localVars['dbURL'],
		$localVars['dbURLOffCampus'],
		$engineVars['openDB']->escape($localVars['updateText']),
		$engineVars['openDB']->escape($localVars['accessType']),
		(empty($localVars['fullTextDB'])?"0":"1"),
		(empty($localVars['newDB'])?"0":"1"),
		(empty($localVars['trialDB'])?"0":"1"),
		$engineVars['openDB']->escape($localVars['accessPlainText']),
		$engineVars['openDB']->escape($localVars['helpText']),
		$engineVars['openDB']->escape($localVars['helpURL']),
		$engineVars['openDB']->escape($localVars['dbDesc']),
		$engineVars['openDB']->escape($updateDate),
		(empty($localVars['popular'])?"0":"1"),
		$localVars['trialExpireDate'],
		$engineVars['openDB']->escape($dbID)
		);
	}
	
	$engineVars['openDB']->sanitize = FALSE;
	$sqlResult = $engineVars['openDB']->query($sql);
	
	if (!$sqlResult['result']) {
		$error = TRUE;
		print webHelper_errorMsg("SQL Error, databases Insert:".$sqlResult['error']."<br /> SQL:".$sql);
	}
	
	if ($dbID == "null") {
		$dbID = $sqlResult['id'];
		$localVars['dbID'] = $dbID;
	}
	
	if ($error == FALSE) {

		if ($cleanPost['MYSQL']['newEntry'] != "null") {
			$sql = sprintf("DELETE from databases_subjects WHERE dbID= %s",
				$engineVars['openDB']->escape($dbID)
				);

			$engineVars['openDB']->sanitize = FALSE;
			$sqlResult = $engineVars['openDB']->query($sql);

			if (!$sqlResult['result']) {
				$error = TRUE;
				print webHelper_errorMsg("SQL Error, subjects Delete:".$sqlResult['error']);
			}
		}
		if(!empty($cleanPost['HTML']['subjects'])) {
			foreach ($cleanPost['HTML']['subjects'] as $value) {

				$sql = sprintf("INSERT INTO databases_subjects (dbID,subjectID) values(%s,%s)",
					$engineVars['openDB']->escape($dbID),
					$engineVars['openDB']->escape($value)
					);

				$engineVars['openDB']->sanitize = FALSE;
				$sqlResult = $engineVars['openDB']->query($sql);

				if (!$sqlResult['result']) {
					$error = TRUE;
					print webHelper_errorMsg("SQL Error, subjects Insert:".$sqlResult['error']);
				}

			}
		}

		if ($cleanPost['MYSQL']['newEntry'] != "null") {
			$sql = sprintf("DELETE from databases_resourceTypes WHERE dbID= %s",
				$engineVars['openDB']->escape($dbID)
				);

			$engineVars['openDB']->sanitize = FALSE;
			$sqlResult = $engineVars['openDB']->query($sql);

			if (!$sqlResult['result']) {
				$error = TRUE;
				print webHelper_errorMsg("SQL Error, resourceTypes Delete:".$sqlResult['error']);
			}
		}
		if(!empty($cleanPost['HTML']['resourceTypes'])) {
			foreach ($cleanPost['HTML']['resourceTypes'] as $value) {

				$sql = sprintf("INSERT INTO databases_resourceTypes (dbID,resourceID) values(%s,%s)",
					$engineVars['openDB']->escape($dbID),
					$engineVars['openDB']->escape($value)
					);

				$engineVars['openDB']->sanitize = FALSE;
				$sqlResult = $engineVars['openDB']->query($sql);

				if (!$sqlResult['result']) {
					$error = TRUE;
					print webHelper_errorMsg("SQL Error, resourceTypes Insert:".$sqlResult['error']);
				}

			}
		}
	}
	
	if($error == FALSE) {
		if ($cleanPost['MYSQL']['newEntry'] == "null") {
			print webHelper_successMsg("Successfully added new database.");
		}
		else {
			print webHelper_successMsg("Successfully updated new database.");
		}
	}
	
}

?>
