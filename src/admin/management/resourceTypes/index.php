<?php
require_once "../../engineHeader.php";

recurseInsert("includes/forms/resourceTypes.php","php");

templates::display('header');
?>

<header>
<h1>Resource Types Management</h1>
</header>

<section>
{form name="ResourceTypes" display="form"}
</section>

<section>
{form name="ResourceTypes" display="editTable"}
</section>


<?php
templates::display('footer');
?>