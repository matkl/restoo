$(document).ready( function(){
	$('#packages a.ajaxAction').live( 'click', handlePackageAction );
	$('#planning a.ajaxAction').live( 'click', handlePlanningAction );
	
	$('.to-load').each( function( index, element ){
		url = $(element).attr('data-load');
		$(element).load( url );
	});
});

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