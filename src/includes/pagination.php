<?php 
$localvars = localvars::getInstance();
if (!in_array($_SERVER['SCRIPT_NAME'], $localvars->get("noPagination"))) { 
?>
<div class="pagingContainer">
<div style="clear:both;"></div>
<hr />
<div style="clear:both;"></div>
<div class="database-content-paging right">
	<span class="pagingPrevious" data-previous="">« Previous</span> | <span class="database-content-paging-pages"><span class="beginningResult">x</span> - <span class="endResult">y</span> of <span class="totalResults">z</span></span> | <span class="pagingNext" data-next="">Next »</span>
</div>
</div>
<?php } ?>