$(document).ready( function(){
	$('#packages a.packageAction').live( 'click', handlePackageAction );
});

function handlePackageAction( event ){
	var url = $(this).attr('href');
	$('#packages').load( url );
	event.preventDefault();
}