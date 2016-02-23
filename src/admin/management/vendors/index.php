<?php
require_once "../../engineHeader.php";

recurseInsert("includes/forms/vendors.php","php");

templates::display('header');
?>

<header>
<h1>Vendor Management</h1>
</header>

<section>
{form name="Vendors" display="form"}
</section>

<section>
{form name="Vendors" display="editTable"}
</section>


<?php
templates::display('footer');
?>