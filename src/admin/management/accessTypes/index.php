<?php
require_once "../../../engineHeader.php";

recurseInsert("includes/forms/accessTypes.php","php");

templates::display('header');
?>

<header>
<h1>Access Type Management</h1>
</header>

<section>
{form name="accessTypes" display="form"}
</section>

<section>
{form name="accessTypes" display="editTable"}
</section>


<?php
templates::display('footer');
?>