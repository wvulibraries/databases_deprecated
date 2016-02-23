<?php
require_once "../engineHeader.php";

try {
	$databaseID = isset($_GET['MYSQL']['id']) ? $_GET['MYSQL']['id'] : NULL;

	$dbObj = new databases;
	if (!isnull($databaseID) && is_empty($dbObj->get($databaseID))) {
		throw new Exception("Database not found");
	}

}
catch (Exception $e) {
	errorHandle::errorMsg($e->getMessage());
	$databaseID = NULL;
}

recurseInsert("includes/forms/database.php","php");

$localvars->set("result",errorHandle::prettyPrint());

templates::display('header');
?>

<header>
<h1>Database Management</h1>
</header>

{local var="results"}

<section>
{form name="Database" display="form"}
</section>


<?php
templates::display('footer');
?>