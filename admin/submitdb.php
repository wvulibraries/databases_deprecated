<?php

global $engine;

$dbTables  = $engine->dbTablesExport();

$error   = "";

buildDBArray($engine->cleanPost);

if (empty($engine->cleanPost['MYSQL']['dbName'])) {
	$error .= webHelper_errorMsg("Database Name is Required.");
}
if (empty($engine->cleanPost['MYSQL']['dbURL'])) {
	$error .= webHelper_errorMsg("Database URL is Required.");
}
if (isnull($engine->cleanPost['MYSQL']['dbStatus'])) {
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
		
	$dbID = $engine->cleanPost['MYSQL']['newEntry'];
	$engine->localVars('dbID', $dbID);
	
	$localVars = $engine->localVarsExport();
		
	$localtime = time();
	$updateDate = $localtime;
	$createDate = $localtime;
	
	$error = FALSE;
	
	$sql = "";
	if ($engine->cleanPost['MYSQL']['newEntry'] == "null") {
		$sql = sprintf("INSERT INTO %s (name,status,yearsOfCoverage,vendor,url,offCampusURL,updated,accessType,fullTextDB,newDatabase,trialDatabase,access,help,helpURL,description,createDate,updateDate,URLID,popular,trialExpireDate) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$dbTables['databases']['prod'],
			$engine->openDB->escape($localVars['dbName']),
			$engine->openDB->escape($localVars['dbStatus']),
			$engine->openDB->escape($localVars['yearsOfCoverage']),
			$engine->openDB->escape($localVars['vendors']),
			$localVars['dbURL'],
			$localVars['dbURLOffCampus'],
			$engine->openDB->escape($localVars['updateText']),
			$engine->openDB->escape($localVars['accessType']),
			(empty($localVars['fullTextDB'])?"0":"1"),
			(empty($localVars['newDB'])?"0":"1"),
			(empty($localVars['trialDB'])?"0":"1"),
			$engine->openDB->escape($localVars['accessPlainText']),
			$engine->openDB->escape($localVars['helpText']),
			$engine->openDB->escape($localVars['helpURL']),
			$engine->openDB->escape($localVars['dbDesc']),
			$engine->openDB->escape($createDate),
			$engine->openDB->escape($updateDate),
			$engine->openDB->escape($localtime),
			(empty($localVars['popular'])?"0":"1"),
			$localVars['trialExpireDate']
			);
	}
	else {
		$sql = sprintf("UPDATE %s SET name='%s', status='%s', yearsOfCoverage='%s', vendor='%s', url='%s', offCampusURL='%s', updated='%s', accessType='%s', fullTextDB='%s', newDatabase='%s', trialDatabase='%s', access='%s', help='%s', helpURL='%s', description='%s', updateDate='%s', popular='%s', trialExpireDate='%s' WHERE ID=%s",
		$dbTables['databases']['prod'],
		$engine->openDB->escape($localVars['dbName']),
		$engine->openDB->escape($localVars['dbStatus']),
		$engine->openDB->escape($localVars['yearsOfCoverage']),
		$engine->openDB->escape($localVars['vendors']),
		$localVars['dbURL'],
		$localVars['dbURLOffCampus'],
		$engine->openDB->escape($localVars['updateText']),
		$engine->openDB->escape($localVars['accessType']),
		(empty($localVars['fullTextDB'])?"0":"1"),
		(empty($localVars['newDB'])?"0":"1"),
		(empty($localVars['trialDB'])?"0":"1"),
		$engine->openDB->escape($localVars['accessPlainText']),
		$engine->openDB->escape($localVars['helpText']),
		$engine->openDB->escape($localVars['helpURL']),
		$engine->openDB->escape($localVars['dbDesc']),
		$engine->openDB->escape($updateDate),
		(empty($localVars['popular'])?"0":"1"),
		$localVars['trialExpireDate'],
		$engine->openDB->escape($dbID)
		);
	}
	
	$engine->openDB->sanitize = FALSE;
	$sqlResult = $engine->openDB->query($sql);
	
	if (!$sqlResult['result']) {
		$error = TRUE;
		print webHelper_errorMsg("SQL Error, databases Insert:".$sqlResult['error']."<br /> SQL:".$sql);
	}
	
	if ($dbID == "null") {
		$dbID = $sqlResult['id'];
		$engine->localVars('dbID', $dbID);
	}
	
	if ($error == FALSE) {

		if ($engine->cleanPost['MYSQL']['newEntry'] != "null") {
			$sql = sprintf("DELETE from databases_subjects WHERE dbID= %s",
				$engine->openDB->escape($dbID)
				);

			$engine->openDB->sanitize = FALSE;
			$sqlResult = $engine->openDB->query($sql);

			if (!$sqlResult['result']) {
				$error = TRUE;
				print webHelper_errorMsg("SQL Error, subjects Delete:".$sqlResult['error']);
			}
		}
		if(!empty($engine->cleanPost['HTML']['subjects'])) {
			foreach ($engine->cleanPost['HTML']['subjects'] as $value) {

				$sql = sprintf("INSERT INTO databases_subjects (dbID,subjectID) values(%s,%s)",
					$engine->openDB->escape($dbID),
					$engine->openDB->escape($value)
					);

				$engine->openDB->sanitize = FALSE;
				$sqlResult = $engine->openDB->query($sql);

				if (!$sqlResult['result']) {
					$error = TRUE;
					print webHelper_errorMsg("SQL Error, subjects Insert:".$sqlResult['error']);
				}

			}
		}

		if ($engine->cleanPost['MYSQL']['newEntry'] != "null") {
			$sql = sprintf("DELETE from databases_resourceTypes WHERE dbID= %s",
				$engine->openDB->escape($dbID)
				);

			$engine->openDB->sanitize = FALSE;
			$sqlResult = $engine->openDB->query($sql);

			if (!$sqlResult['result']) {
				$error = TRUE;
				print webHelper_errorMsg("SQL Error, resourceTypes Delete:".$sqlResult['error']);
			}
		}
		if(!empty($engine->cleanPost['HTML']['resourceTypes'])) {
			foreach ($engine->cleanPost['HTML']['resourceTypes'] as $value) {

				$sql = sprintf("INSERT INTO databases_resourceTypes (dbID,resourceID) values(%s,%s)",
					$engine->openDB->escape($dbID),
					$engine->openDB->escape($value)
					);

				$engine->openDB->sanitize = FALSE;
				$sqlResult = $engine->openDB->query($sql);

				if (!$sqlResult['result']) {
					$error = TRUE;
					print webHelper_errorMsg("SQL Error, resourceTypes Insert:".$sqlResult['error']);
				}

			}
		}
	}
	
	if($error == FALSE) {
		if ($engine->cleanPost['MYSQL']['newEntry'] == "null") {
			print webHelper_successMsg("Successfully added new database.");
		}
		else {
			print webHelper_successMsg("Successfully updated new database.");
		}
	}
	
}

?>
