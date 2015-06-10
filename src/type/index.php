<?php
require "../engineHeader.php";

switch($_GET['HTML']['type']) {
	case "new":
	$pageHeader = "New";
	$searchType = "newDatabase";
	break;
	case "trial":
	$pageHeader = "Trial";
	$searchType = "trialDatabase";
	break;
	case "full":
	$pageHeader = "Full Text";
	$searchType = "fullTextDB";
	break;
	case "alumni":
	$pageHeader = "Alumni";
	$searchType = "alumni";
	break;
	case "mobile":
	$pageHeader = "Mobile";
	$searchType = "mobile";
	break;
	default:
	$pageHeader = "Error (Defaulting to Full Text)";
	$searchType = "fullTextDB";
}

$localvars->set("pageHeader",$pageHeader);

$dbObject  = new databases;
$databases = $dbObject->getByType($searchType);
$localvars->set("databases",lists::databases($databases));

templates::display('header'); 
?>


<!-- Page Content Goes Below This Line -->

<div class="clearfix" id="subjectsContainer">

<h3>{local var="pageHeader"} Databases</h3>


{local var="databases"}

</div>

<div id="rightNav">

<?php
	recurseInsert("rightNav.php","php");
?>

</div>
<!-- Page Content Goes Above This Line -->

<?php
templates::display('footer'); 
?>