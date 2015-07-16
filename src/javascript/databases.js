$(function() {
	$(document)
		.on('click',  '.breadcrumbClicking',   handler_breadcrumbClicking)
});

function handler_breadcrumbClicking() {

	var breadcrumb = '<li class="breadcrumb-facet" data-breadcrumb-facet="'+$(this).attr("data-breadcrumb")+'"><span class="facetLi">'+$(this).attr("data-breadcrumb")+'</span></li>';

	$( breadcrumb ).appendTo(".database-content-facets-ul");

	return false;

}
