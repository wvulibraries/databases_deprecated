<?php
require_once "../../../engineHeader.php";

$ignore_form_builder = true;

try {
	if (($subject = subjects::get($_GET['MYSQL']['id'])) === false) {
		throw new Exception("Error retrieving subject.");
	}
	if (!isset($subject[0])) {
		throw new Exception("Subject not found.");
	}

	$localvars->set("subject_name",$subject[0]['name']);

	// handle submission
	if (isset($_POST['MYSQL']['sort_submit'])) {

		foreach ($_POST['MYSQL'] as $I=>$V) {

			if (is_numeric($I)) {
				$sql = sprintf("UPDATE `databases_curated` set `sort`=? WHERE `ID`=?");
				$sqlResult = $db->query($sql,array($V,$I));

				if ($sqlResult->error()) {
					throw new Exception("Error updating database sorting.");
				}
			}

		}

	}

	// build the sort table

	$sql       = sprintf("SELECT `databases_curated`.`ID` as `ID`, `databases_curated`.`sort` as `sort`, `dbList`.`name` as `db_name` FROM `databases_curated` LEFT JOIN `dbList` ON `dbList`.`ID`=`databases_curated`.`dbID` WHERE `subjectID`=? ORDER BY `sort`,`db_name`");
	$sqlResult = $db->query($sql,array($_GET['MYSQL']['id']));

	if ($sqlResult->error()) {
		throw new Exception("Error getting sort information.");
	}

	$table_array = array();
	while($row = $sqlResult->fetch()) {
		$table_array[] = array("sort"=> sprintf('<input type="text" value="%s" name="%s" style="width:3em !important;"/>',$row['sort'],$row['ID']),
			"dbName" => $row['db_name']
			);
	}

	$table           = new tableObject("array");
	$table->sortable = false;
	$table->summary  = "Curated Database Sort Table";
	$table->class    = "styledTable";

	$headers = array();
	$headers[] = "Sort Order";
	$headers[] = "Database Name";

	$table->headers($headers);
	$localvars->set("curated_table",$table->display($table_array));

}
catch (Exception $e) {
	errorHandle::errorMsg($e->getMessage());
	$databaseID = NULL;
}

$localvars->set("results",errorHandle::prettyPrint());

templates::display('header');
?>

<header>
<h1>Order curated databases for: {local var="subject_name"}</h1>
</header>

{local var="results"}

<section>

<form action="" method="post">

{csrf}

{local var="curated_table"}

<input type="submit" name="sort_submit" value="Update" />

</form>

</section>

<?php
templates::display('footer');
?>