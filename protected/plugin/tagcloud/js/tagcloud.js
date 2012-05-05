$(document).ready(function(){
	$("#search-button").click(function(){
		$.post("?route=/tagcloud/tagcloud&m=save", { title: $("#search-form [name='title']").val() });
	});
	
	$(".taglink").click(function(){ 
		$("#overlay").fadeIn();
		$("#overlay-inner").fadeIn();
		var reqTitle = $(this).attr('title');
		var requestType = 'search';
		var reqString = 'lang=all&user=all&title='+reqTitle+'&code=&d1=&d2=';
		$("#overlay-content").load('?route=/application/schnippets&m=search&'+reqString+'&search='+requestType, function(){
			$("table").tablesorter();
		}); 
	});
	
});
