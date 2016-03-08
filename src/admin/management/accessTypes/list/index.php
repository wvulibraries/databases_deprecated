<?php
require_once "../../../engineHeader.php";

$sql       = sprintf("SELECT * FROM `dbList` WHERE `accessType`=? ORDER BY `name`");
$sqlResult = $db->query($sql,array($_GET['MYSQL']['id']));

$output = "<ul>";
while($row = $sqlResult->fetch()) {

	$output .= sprintf('<li><a href="%s/admin/database/?id=%s">%s</a></li>',
		$localvars->get("databaseHome"),
		$row['ID'],
		$row['name']);

}
$output .= "</ul>";

$sql       = "SELECT `name` FROM `accessTypes` WHERE `ID`=? LIMIT 1";
$sqlResult = $db->query($sql,array($_GET['MYSQL']['id']));
$row       = $sqlResult->fetch();

$localvars->set("accessTypeName",$row['name']);
$localvars->set("databases",$output);

templates::display('header');
?>

<header>
<h1>Databases assign to Access Type: {local var="accessTypeName"}</h1>
</header>

{local var="databases"}

<?php
templates::display('footer');
?>