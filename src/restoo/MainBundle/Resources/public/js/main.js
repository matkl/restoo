$(document).ready( function(){
	initializeEmbedForms();
	
});


//---- js for embed forms-------------

function initializeEmbedForms() {
	//add remove buttons to all existing elements
	$("div[data-prototype]").each(function(index) {
	    $(this).find("> div").append('<a href="#" class="deleteElement">Delete element</a></li>');
	});
	//add click handler
	$('a.deleteElement').click(removeFormCollectionElement);
	$('a.addElement').click(addFormCollectionElement);
}

function removeFormCollectionElement(event) {
	$(this).parent().remove();
	return false;
}

function addFormCollectionElement( event ) {
	var collectionHolder = $("div[data-prototype]");
	var prototype = collectionHolder.attr('data-prototype');
	var form = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);
	var removeButton = $('<a href="#" class="deleteElement">Delete element</a></li>');
	removeButton.click(removeFormCollectionElement);
	form = $(form).append(removeButton);
	collectionHolder.append(form);
	return false;
}

//-----------------------------