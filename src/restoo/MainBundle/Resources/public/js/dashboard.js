$(document).ready( function(){
	$('#packages a.ajaxAction').live( 'click', handlePackageAction );
	$('#planning a.ajaxAction').live( 'click', handlePlanningAction );
	
	$('.to-load').each( function( index, element ){
		url = $(element).attr('data-load');
		$(element).load( url );
	});
	
	$('a.popupAction').live('click', openPopup );
});

function openPopup() {
	var $this = $(this);
	var outputHolder = $("<div id='.popupConent'></div>");
	$("body").append(outputHolder);
		outputHolder.load($this.attr("href"), null, function() {
			outputHolder.dialog( {
					modal: true,
					close: function(event, ui) {
						//@TODO refresh dashboard
					}
			});
		});
	return false;
}

function handlePlanningAction( event ) {
	var url = $(this).attr('href');
	$('#planning').load( url );
	event.preventDefault();
}

function handlePackageAction( event ){
	var url = $(this).attr('href');
	$('#packages').load( url );
	event.preventDefault();
}