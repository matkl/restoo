$(document).ready( function(){
	$('#packages a.packageAction').live( 'click', handlePackageAction );
	
	$('.to-load').each( function( index, element ){
		url = $(element).attr('data-load');
		$(element).load( url );
	});
});

function handlePackageAction( event ){
	var url = $(this).attr('href');
	$('#packages').load( url );
	event.preventDefault();
}