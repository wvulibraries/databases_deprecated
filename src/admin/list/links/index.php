<?php
require "../../../engineHeader.php";

$dbObject  = new databases;
$databases = $dbObject->getByType("status");

$databases = array_map(function($a){
	$localvars  = localvars::getInstance();
	foreach ($a as $I=>$V) {
		if($I != "name" && $I !="URLID") unset($a[$I]);
	} 
	$a['URLID'] = sprintf('<a href="https://%s%s?%s=INVS">https://%s%s?%s=INV</a>',$_SERVER['HTTP_HOST'],$localvars->get('connectURL'),$a['URLID'],$_SERVER['HTTP_HOST'],$localvars->get('connectURL'),$a['URLID']);
	return $a;
}, $databases);


$table          = new tableObject("array");
$table->summary = "Database links";

$headers   = array();
$headers[] = "Title";
$headers[] = "URL";
$table->headers($headers);

$localvars->set("databaseTable",$table->display($databases));

templates::display('header');
?>

<style>
	.sticky-header {
		display:none;
	}
</style>

{local var="databaseTable"}

<?php
templates::display('footer');
?>