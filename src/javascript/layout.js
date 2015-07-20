var facetfun = "";

// If JavaScript Enabled - Setup
$(document).ready(function() {
  $(".wvu-header .list").addClass("destroy"); 
  $(".wvrhc-header .list2").addClass("destroy");   
  $("#wvrhctoggle .fa-chevron-up").addClass("hiding"); 
  $("#wvutoggle .fa-chevron-up").addClass("hiding"); 
  $("#menu-toggle #menu-toggle2").addClass("hiding");
  $("#top-toggle #top-toggle2").addClass("hiding");
  $("#search-toggle #search-toggle2").addClass("hiding");
  $("#facet-toggle #filter-toggle2").addClass("hiding");  

	facetfun   = $('#sidebar').html();
	messagefun = $('.search-query-form').html();
});

//Help Message Move 
//(may need to subtract scrollbar width for desktop detection)
$(window).bind("load resize", function() {

	$('.search-query-form-message').remove();

	if( $(window).width() < 768) {
  		$('.search-query-form').html(messagefun);
	}
  	else { 
  		$('#main-container-alert').html(messagefun);
	} 
});

//Mobile Facet Move
$(window).bind("load resize", function() {

	$('#facets').remove();

	if( $(window).width() < 768) {
  		$('.sticky-header-filter-sidebar').html(facetfun);
  		
  		$(".facets-header").click(function() {
    		$(this).next("ul").slideToggle("fast");
    		console.log('test 2');
    	});
	}
  	else { 
  		$('#sidebar').html(facetfun);
  		
  		$(".facets-header").click(function() {
    		$(this).next("ul").slideToggle("fast");
    		console.log('test');
    	});
	} 
});


// Mobile Facet Setup
$(document).ready(function() {

	var windowh = document.documentElement.clientHeight;
	var tabbar  = $('.sticky-header').height();
	
	var fheight = windowh - tabbar;

    $('.sticky-header-filter-sidebar').css('max-height', fheight);  
    $('.search-query-form').css('max-height', fheight);  

});

// Mobile Facet Resize
$(window).resize(function(){

	var windowh = document.documentElement.clientHeight;
	var tabbar  = $('.sticky-header').height();
	
	var fheight = windowh - tabbar;

    $('.sticky-header-filter-sidebar').css('max-height', fheight);  
    $('.search-query-form').css('max-height', fheight); 

});



// Mobile WVU Nav
$(function () {
	$("#wvutoggle").click(function () {		
		$(".list").slideToggle("fast");
		$("#wvutoggle .fa-chevron-up").toggleClass("hiding");
		$("#wvutoggle .fa-chevron-down").toggleClass("hiding");
	});
});

// Tab Bar Navigation: Menu
$(function () {
	$("#menu-toggle").click(function () {		
		$(".sticky-header-nav").toggleClass("tabbarBlue");
		$("#menu-toggle #menu-toggle1").toggleClass("hiding");
		$("#menu-toggle #menu-toggle2").toggleClass("hiding");

		$(".sticky-header-top").removeClass("tabbarBlue");
		$("#top-toggle #top-toggle1").removeClass("hiding");
		$("#top-toggle #top-toggle2").addClass("hiding");		

		$(".search-query-form").removeClass("tabbarToggle2");
		$(".search-query-form").removeClass("tabbarToggleSearch");
		$(".sticky-header-search").removeClass("tabbarBlue");
		$("#search-toggle #search-toggle1").removeClass("hiding");
		$("#search-toggle #search-toggle2").addClass("hiding");	

		$(".sticky-header-filter-sidebar").removeClass("tabbarToggle2");
		$(".sticky-header-filter").removeClass("tabbarBlue");
		$("#facet-toggle #filter-toggle1").removeClass("hiding");
		$("#facet-toggle #filter-toggle2").addClass("hiding");	
	});
});

// Tab Bar Navigation: Top
$(function () {
	$("#top-toggle").click(function () {		
		$(".sticky-header-top").toggleClass("tabbarBlue");
		$("#top-toggle #top-toggle1").toggleClass("hiding");
		$("#top-toggle #top-toggle2").toggleClass("hiding");

		$(".sticky-header-nav").removeClass("tabbarBlue");
		$("#menu-toggle #menu-toggle1").removeClass("hiding");
		$("#menu-toggle #menu-toggle2").addClass("hiding");

		$(".search-query-form").removeClass("tabbarToggle2");
		$(".search-query-form").removeClass("tabbarToggleSearch");
		$(".sticky-header-search").removeClass("tabbarBlue");
		$("#search-toggle #search-toggle1").removeClass("hiding");
		$("#search-toggle #search-toggle2").addClass("hiding");	

		$(".sticky-header-filter-sidebar").removeClass("tabbarToggle2");
		$(".sticky-header-filter").removeClass("tabbarBlue");
		$("#facet-toggle #filter-toggle1").removeClass("hiding");
		$("#facet-toggle #filter-toggle2").addClass("hiding");	
	});
});

// Tab Bar Navigation: Help
$(function () {
	$("#search-toggle").click(function () {		
		$(".search-query-form").toggleClass("tabbarToggle2");
		$(".search-query-form").toggleClass("tabbarToggleSearch");
		$(".sticky-header-search").toggleClass("tabbarBlue");
		$("#search-toggle #search-toggle1").toggleClass("hiding");
		$("#search-toggle #search-toggle2").toggleClass("hiding");

		$(".sticky-header-top").removeClass("tabbarBlue");
		$("#top-toggle #top-toggle1").removeClass("hiding");
		$("#top-toggle #top-toggle2").addClass("hiding");		

		$(".sticky-header-nav").removeClass("tabbarBlue");
		$("#menu-toggle #menu-toggle1").removeClass("hiding");
		$("#menu-toggle #menu-toggle2").addClass("hiding");

		$(".sticky-header-filter-sidebar").removeClass("tabbarToggle2");
		$(".sticky-header-filter").removeClass("tabbarBlue");
		$("#facet-toggle #filter-toggle1").removeClass("hiding");
		$("#facet-toggle #filter-toggle2").addClass("hiding");		
	});
});

// Tab Bar Navigation: Filter
$(function () {
	$("#facet-toggle").click(function () {		
		$(".sticky-header-filter-sidebar").toggleClass("tabbarToggle2");
		$(".sticky-header-filter-sidebar").toggleClass("tabbarToggleSearch");
		$(".sticky-header-filter").toggleClass("tabbarBlue");
		$("#facet-toggle #filter-toggle1").toggleClass("hiding");
		$("#facet-toggle #filter-toggle2").toggleClass("hiding");

		$(".sticky-header-top").removeClass("tabbarBlue");
		$("#top-toggle #top-toggle1").removeClass("hiding");
		$("#top-toggle #top-toggle2").addClass("hiding");		

		$(".sticky-header-nav").removeClass("tabbarBlue");
		$("#menu-toggle #menu-toggle1").removeClass("hiding");
		$("#menu-toggle #menu-toggle2").addClass("hiding");

		$(".search-query-form").removeClass("tabbarToggle2");
		$(".search-query-form").removeClass("tabbarToggleSearch");
		$(".sticky-header-search").removeClass("tabbarBlue");
		$("#search-toggle #search-toggle1").removeClass("hiding");
		$("#search-toggle #search-toggle2").addClass("hiding");			
	});
});

// Facet Size
$(window).load(function() {

	var faceth = $('#sidebar').height();
	var facetw = $('#sidebar #facets').width();
	var mainw  = $('#main-container .wrap').width();

	if( $(window).width() < 768) {
  		var flexw = mainw - facetw;
	}
  	else { 
  		var flexw = mainw - facetw - 50;
	} 

    $('.database-content').css('min-height', faceth);  
    $('.database-content').css('width', flexw);  

});

$(window).resize(function(){

	var faceth = $('#sidebar').height();
	var facetw = $('#sidebar #facets').width();
	var mainw  = $('#main-container .wrap').width();

	if( $(window).width() < 768) {
  		var flexw = mainw - facetw;
	}
  	else { 
  		var flexw = mainw - facetw - 50;
	} 

    $('.database-content').css('min-height', faceth);  
    $('.database-content').css('width', flexw);  

});

// Database Column Resizing
equalheight = function(container){

	var currentTallest = 0,
	currentRowStart    = 0,
	rowDivs            = new Array(),
	$el,
	topPosition        = 0;

	$(container).each(function() {

		$el = $(this);
		$($el).height('auto')
		topPostion = $el.position().top;

		if (currentRowStart != topPostion) {
	
			for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
				rowDivs[currentDiv].height(currentTallest);
			}

			rowDivs.length  = 0; // empty the array
			currentRowStart = topPostion;
			currentTallest  = $el.height();
    		rowDivs.push($el);
    	} 
    	else {
    		rowDivs.push($el);
    		currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    	}
    	for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
    		rowDivs[currentDiv].height(currentTallest);
    	}
    });

    console.log("working");

}

$(document).ready(function() {
  equalheight('.database-res');
});

$(window).load(function() {
  equalheight('.database-res');
});

$(window).resize(function(){
  equalheight('.database-res');
});

$(window).load(function() {
  equalheight('.database-resize');
});

$(document).ready(function() {
  equalheight('.database-resize');
});

$(window).resize(function(){
  equalheight('.database-resize');
});


