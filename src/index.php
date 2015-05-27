<?php

require_once "/home/www.libraries.wvu.edu/public_html/includes/2014/engineHeader.php";

$engine->localVars('pageTitle',"WVU Libraries: Databases");
// $engine->eTemplate("load","library2012.2col.right");
$engine->eTemplate("load","library2014-backpage");

recurseInsert("dbTables.php","php");
require("/home/library/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php");
$engineVars['openDB'] = $engine->dbConnect("database","databases",FALSE);

// Fire up the Engine
$engine->eTemplate("include","header");

?>

<?php

// Check for and expire trial databases
$sql = "UPDATE dbList set status='2' WHERE trialDatabase=1 AND trialExpireDate<".time();
$engineVars['openDB']->sanitize = FALSE;
$sqlResult = $engineVars['openDB']->query($sql);
//

$localVars['status'] = 1;
if(!empty($engine->cleanGet['HTML']['status']) && isint($engine->cleanGet['HTML']['status'])) {
	$localVars['status'] = $engine->cleanGet['HTML']['status'];
}

?>

<?php

recurseInsert("buildLists.php","php");
$subjects = buildSubjectList();
localVars::add("subjects",$subjects);

?>

<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>Databases by Subject</h3>

{local var="subjects"}

</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<!-- <script type="text/javascript" src="http://s3.amazonaws.com/new.cetrk.com/pages/scripts/0008/8415.js"> </script> -->

<?php
$engine->eTemplate("include","footer");
?>