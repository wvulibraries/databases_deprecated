<?php
require_once "../../../engineHeader.php";

recurseInsert("includes/forms/ipLocations.php","php");
print "<pre>";
var_dump($_SERVER);
print "</pre>";
templates::display('header');
?>

<header>
<h1>IP Range Management</h1>
</header>

<section>
{form name="ipLocations" display="form"}
</section>

<section>
{form name="ipLocations" display="editTable"}
</section>


<?php
templates::display('footer');
?>