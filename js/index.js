$(document).ready(function(){
	
	footerPosition(); 
	
	$("#search-button").click(showSearchResults);
	
	$("#overlay-close").click(function(){
		$("#overlay").fadeOut('fast', function(){
			$("#overlay-content").html('<img id="loader" src="images/loader.gif" />');
		});
	});
	
   $("#message-close").click(function(){
        $("#message").fadeOut('fast', function(){
            
        });
    });
	
	$("form#search-form input:text").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#search-button").trigger("click");
	    }
	});
	
	$("#expand").toggle(function(){
	    $("#container").animate({
	        width: '95%'
	    }, 250, function() {
	        $('#expand').html('Collapse');
	    });
	},function(){
        $("#container").animate({
            width: '960px'
        }, 250, function() {
            $('#expand').html('Expand');
        });
	});
});

$(function() {
    $( ".field-date input" ).datepicker();
});

function showSearchResults(view){
	$("#overlay").fadeIn();
	$("#overlay-inner").fadeIn();
	if (view == 'all') {
		var reqString = 'lang=all&user=all&title=&code=&d1=&d2=';
		var requestType = 'latest';
	} else {
		var reqString = $("form#search-form").serialize();
		var requestType = 'search';
	}
	$("#overlay-content").load('?route=/application/schnippets&m=search&'+reqString+'&search='+requestType, function(){
		$("table").tablesorter();
	});
}

$(window).resize(function() {
    footerPosition();
});

function footerPosition() {
    var document_height = $("#spacer-header").height()+$("#container").height()+102;
    var window_height = $(window).height();
    var footer_height = $("#footer-wrapper").height();
    if (document_height+footer_height <= window_height) {
        $("#spacer-footer").height(window_height-document_height-footer_height);
    }
}