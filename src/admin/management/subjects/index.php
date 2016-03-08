<?php
require_once "../../engineHeader.php";

recurseInsert("includes/forms/subjects.php","php");

templates::display('header');
?>

<header>
<h1>Subject Management</h1>
</header>

<section>
{form name="Subjects" display="form" addGet="true"}
</section>

<section>
  {form name="Subjects" display="edit" expandable="true" addGet="true"}
</section>


<?php
templates::display('footer');
?>
