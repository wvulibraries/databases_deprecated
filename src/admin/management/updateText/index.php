<?php
require_once "../../../engineHeader.php";

recurseInsert("includes/forms/updateText.php","php");

templates::display('header');
?>

<header>
<h1>Update Text Management</h1>
</header>

<section>
{form name="UpdateText" display="form"}
</section>

<section>
{form name="UpdateText" display="editTable"}
</section>


<?php
templates::display('footer');
?>