<?php

require_once '/home/www.libraries.wvu.edu/phpincludes/engine/engineAPI/4.0/engine.php';
$engine = EngineAPI::singleton();

// Setup the database connection
$databaseOptions = array(
	'username' => 'username',
	'password' => 'password'
);
require_once('/home/www.libraries.wvu.edu/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php');
$databaseOptions['dbName'] = 'databases';
$db                        = db::create('mysql', $databaseOptions, "appDB");

$sql       = sprintf("SELECT `ID`, `name` FROM `dbList`");
$sqlResult = $db->query($sql);

if ($sqlResult->error()) {
	print "error\n";
	die;
}	

while($row = $sqlResult->fetch()) {

	$search_name = preg_replace("/\&.+\;/", "", $row['name']);
	$search_name = preg_replace("/ and /", "", $search_name);
	$search_name = preg_replace("/\W/", "", $search_name);

	$sql       = sprintf("UPDATE `dbList` SET `titleSearch`=? WHERE `ID`=?");
	$sqlResult2 = $db->query($sql,array($search_name,$row['ID']));

	if ($sqlResult2->error()) {
		print "error\n";
		die;
	}	

}

?>