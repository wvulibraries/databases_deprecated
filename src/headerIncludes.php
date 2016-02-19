<?php

$localvars = localvars::getInstance();

if (!preg_match("/\/databases\/?(index.php)?$/",$_SERVER['REQUEST_URI'])) {
	$localvars->set("enableBreadcrumbClicking","breadcrumbClicking");
}

if ($localvars->get("subjectsPage")) {
	$localvars->set("popularDatabases",topPickDBs::getTopPicksForSubject($localvars->get("subjectsPage")));
}
else {
	$dbObject         = new databases;
	$localvars->set("popularDatabases",$dbObject->getByType("popular"));
}

$localvars->set("popular",lists::popular($localvars->get("popularDatabases")));

?>

<script src="{local var="databaseHome"}/javascript/databases.js"></script>

<link href="/databases/stylesheets/jquery.marcoPolo.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="/databases/javascript/jquery.marcopolo.min.js"></script>
	<script type="text/javascript" src="/databases/javascript/jquery.ui.widget.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {

      $(function () {
        $('#dbn').marcoPolo({
          url: "/databases/search/progessive/",
          formatItem: function (data, $item) {
            return data.name;
          },
          minChars: 2,
          onSelect: function (data, $item) {
            this.val(data.name);
          },
          param: 'q',
          required: true
        });
      });

	});

	</script>