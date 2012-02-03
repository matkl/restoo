function addJobForm() {
    // Get the div that holds the collection of tags
    var collectionHolder = $('#package_jobs');
    // Get the data-prototype we explained earlier
    var prototype = collectionHolder.attr('data-prototype');
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    form = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);
    // Display the form in the page
    collectionHolder.append(form);
}


$(document).ready( function(){
	// Add the link to add tags
	$('.record_actions').append('<li><a href="#" class="add_job_link">Add a job</a></li>');
	// When the link is clicked we add the field to input another tag
	$('a.add_job_link').click(function(event){
	    addJobForm();
	});
});