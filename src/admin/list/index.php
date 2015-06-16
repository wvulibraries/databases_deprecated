<?php
require "../../engineHeader.php";

// Set the current status to all
http::setGet("status","4");

$dbObject  = new databases;
$databases = $dbObject->getAll();

$databases = array_map(function($a){
	$localvars = localvars::getInstance();
	$dbObject  = new databases;

	$temp['ID']            = sprintf('<a href="%s/admin/database/?id=%s">Edit</a>',$localvars->get('databaseHome'),$a['ID']);
	$temp['name']          = $a['name'];
	$temp['status']        = $dbObject->status($a);
	$temp['trialDatabase'] = ($a['trialDatabase'] == 1)?"Yes -- ".date("M d, Y",$a['trialExpireDate']):"No";
	$temp['vendor']        = vendors::get($a['vendor']);
	$temp['vendor']        = sprintf('<a href="%s">%s</a>',$temp['vendor']['url'],$temp['vendor']['name']);


	return $temp;
}, $databases);


$table          = new tableObject("array");
$table->summary = "Database links";

$headers   = array();
$headers[] = "ID";
$headers[] = "Title";
$headers[] = "Status";
$headers[] = "Trial";
$headers[] = "Vendor";
$table->headers($headers);

$table->sortable = TRUE;

$localvars->set("databaseTable",$table->display($databases));

templates::display('header');
?>

{local var="databaseTable"}

<?php
templates::display('footer');
?>