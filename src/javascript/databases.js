var databasesPerPage = 10;
var currentPagingMax = 10;
var currentPagingMin = 1;
var currentPage      = 1;

$(function() {
	$(document)
		.on('click',  '.breadcrumbClicking',   handler_breadcrumbClicking)
		.on('click',  '.breadcrumb-facet',     handler_destroy_breadcrumb)
		.on('click',  '.pagingNext',           handler_nextPage)
		.on('click',  '.pagingPrevious',       handler_prevPage)
});

$(document).ready(function() {
	updatePagingCounts();
	hideInitialDataSet();
});

function handler_breadcrumbClicking() {

	// Check to see if we already added it to the facets list. If so, ignore it.
	if ($('*[data-breadcrumb-facet="'+$(this).attr("data-breadcrumb")+'"]').length > 0) {
		return false;
	}

	var breadcrumb = '<li class="breadcrumb-facet" data-breadcrumb-facet="'+$(this).attr("data-breadcrumb")+'"><span class="facetLi">'+$(this).attr("data-breadcrumb")+'<i class="fa fa-times"></i></span></li>';

	$( breadcrumb ).appendTo(".database-content-facets-ul");

	updateVisibleDatabases();

	return false;

}

function handler_destroy_breadcrumb() {

	$(this).remove();

	updateVisibleDatabases();

	return false;

}

function handler_nextPage() {

}

function handler_prevPage() {

}

function hideInitialDataSet() {
	$(".database:gt(9)").hide();
	return;
}

function updateVisibleDatabases() {

	var activeFacets = [];

	// get all the active facets
	$(".breadcrumb-facet").each(function() {

		activeFacets.push($(this).attr("data-breadcrumb-facet"));

	});

	// if there is 1 or more active facets
	if (activeFacets.length > 0) {
		// hide all the databases
		$(".database").hide();

		// show only the databases associated with active facets
		var classes = activeFacets.join(".");

		$("."+classes).show();
	}
	else {
		// show all databases
		$(".database").show();
	}

	equalheight('.database-res');
	equalheight('.database-resize');

	updatePagingCounts();

	return;
	
}

function updatePagingCounts() {
	updateTotalDatabases();
	updatePageMax();
	updatePageMin();

	updateNextButton();
	updatePrevButton();
}

function updateTotalDatabases() {
	var totalDatabases = $(".database:visible").length;
	$(".totalResults").html(totalDatabases);
	return;
}

function updatePageMax() {
	$(".endResult").html(currentPagingMax);
}

function updatePageMin() {
	$(".beginningResult").html(currentPagingMin);
}

function updateNextButton() {
	if ($(".database:visible").length <= databasesPerPage ||
		currentPagingMax >= databasesPerPage) {
		$(".pagingNext").addClass("disabledPaginButton");
	}
	else {
		$(".pagingNext").removeClass("disabledPaginButton");
	}
	return;
}

function updatePrevButton() {
	if (currentPage == 1) {
		$(".pagingPrevious").addClass("disabledPaginButton");
	}
	else {
		$(".pagingPrevious").removeClass("disabledPaginButton");
	}
}