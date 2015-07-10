<?php
require_once "../../../../engineHeader.php";

$sql       = sprintf("SELECT * FROM `dbList` WHERE `access`=? ORDER BY `name`");
$sqlResult = $db->query($sql,array($_GET['MYSQL']['id']));

$output = "<ul>";
while($row = $sqlResult->fetch()) {

	$output .= sprintf('<li><a href="%s/admin/database/?id=%s">%s</a></li>',
		$localvars->get("databaseHome"),
		$row['ID'],
		$row['name']);

}
$output .= "</ul>";

$sql       = "SELECT `name` FROM `accessPlainText` WHERE `ID`=? LIMIT 1";
$sqlResult = $db->query($sql,array($_GET['MYSQL']['id']));
$row       = $sqlResult->fetch();

$localvars->set("accessPlainTextName",$row['name']);
$localvars->set("databases",$output);

templates::display('header');
?>

<header>
<h1>Databases assign to Access Plain Text: {local var="accessPlainTextName"}</h1>
</header>

{local var="databases"}

<?php
templates::display('footer');
?>