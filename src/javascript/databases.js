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
	currentPagingMax += databasesPerPage;

	if (currentPagingMax > $(getCurrentSelector()).length) {
		currentPagingMax = $(getCurrentSelector()).length;
		currentPagingMin = (currentPagingMin+databasesPerPage > currentPagingMax)?currentPagingMax:currentPagingMin+databasesPerPage;
	}
	else {
		currentPagingMin += databasesPerPage;
		currentPage++;
	}

	showDatabasePageSet();
}

function handler_prevPage() {

	currentPagingMin -= databasesPerPage;

	if (currentPagingMin < 1) {
		currentPagingMin = 1;
	}
	else {
		currentPagingMax -= databasesPerPage;
		currentPage--;
	}

	if (currentPage < 1) {
		currentPage = 1;
	}

	if (currentPagingMax > databasesPerPage && currentPagingMax % databasesPerPage != 0) {
		currentPagingMax += databasesPerPage - (currentPagingMax % databasesPerPage);
	}
	else if ($(getCurrentSelector()).length < databasesPerPage) {
		currentPagingMax = $(getCurrentSelector()).length;
	}

	showDatabasePageSet();

}

function hideInitialDataSet() {

	setInitialVars();

	// Hide all the databases
	$(".database").hide();

	// show only the 1st ten databases (all or facetted)
	$(getCurrentSelector()+":lt("+(databasesPerPage)+")").show();

	// Resize everything
	equalizeHieghts();

	return;
}

function showDatabasePageSet() {

	$(".database").hide();
	$(getCurrentSelector()).slice((currentPagingMin-1),(currentPagingMin-1+databasesPerPage)).show();

	updatePagingCounts();
	
	equalizeHieghts();
}

function setInitialVars() {

	databasesPerPage = 10;
	currentPagingMax = 10;
	currentPagingMin = 1;
	currentPage      = 1;

}

function updateVisibleDatabases() {

	var activeFacets = [];

	// get all the active facets
	$(".breadcrumb-facet").each(function() {
		activeFacets.push($(this).attr("data-breadcrumb-facet"));
	});

	// remove facetDisplay from all databases
	$(".database").removeClass("facetDisplay");

	// if there is 1 or more active facets
	if (activeFacets.length > 0) {
		// show only the databases associated with active facets
		var classes = activeFacets.join(".");

		// Add the "facetDisplay" class to all the databases that have all the 
		// requested facets
		$("."+classes).addClass("facetDisplay");
	}

	// Because the facets changed, reset to page 1 and reload as a new page
	hideInitialDataSet();

	// Update the pagination
	updatePagingCounts();

	return;
	
}

function updatePagingCounts() {

	if ($(getCurrentSelector()).length < databasesPerPage) {
		currentPagingMax = $(getCurrentSelector()).length;
	}

	updateTotalDatabases();
	updatePageMax();
	updatePageMin();

	updateNextButton();
	updatePrevButton();
}

function updateTotalDatabases() {

	var totalDatabases = $(getCurrentSelector()).length;
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

function getCurrentSelector() {

	if ($(".facetDisplay").length > 0) {
		return ".facetDisplay";
	}

	return ".database";

}