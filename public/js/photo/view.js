/**
* Javascript used on the image view page.  Handles voting and commenting.
*
*/


// Voting
// {{{ voteUp(e)

function voteUp(e) {
    e.preventDefault();
    if($("#imagesView #votesWrapper .thumbsUp").hasClass('highlight') || $("#imagesView #votesWrapper .thumbsDown").hasClass('highlight')) {
        return;
    }

    var input = 'id/' + $("#imagesView #data").attr('value');
    input += '/vote/1';
    
    if(input == 'false') {
        $("#blackout").css('display', 'block');
        $("#signup").css('display', 'block');
        e.preventDefault();
        return;
    }

    $.ajax({
        type: "GET",
		url: "/photo/vote/"+input,
		success: function(data){
		    $("#imagesView #votesWrapper .thumbsUp").addClass('highlight');
		    $("#imagesView #votesWrapper #votes .voteTally").html(data);
	    }
    });
}

// }}}
// {{{ voteDown(e)

function voteDown(e) {
    e.preventDefault();
    if($("#imagesView #votesWrapper .thumbsUp").hasClass('highlight') || $("#imagesView #votesWrapper .thumbsDown").hasClass('highlight')) {
        return;
    }

    var input = 'id/' + $("#imagesView #data").attr('value');
    input += '/vote/-1';
    
    if(input == 'false') {
        $("#blackout").css('display', 'block');
        $("#signup").css('display', 'block');
        e.preventDefault();
        return;
    }
		
    $.ajax({
		type: "GET",
	    url: "/photo/vote/"+input,
		success: function(data){
		    $("#imagesView #votesWrapper .thumbsDown").addClass('highlight');
		    $("#imagesView #votesWrapper #votes .voteTally").html(data);
		}
    });
}

// }}}


// {{{ $(document).ready();

/**
* Assign the actions.
*/
$(document).ready(function() {
	$("#imagesView #votesWrapper .thumbsUp").live('click', voteUp);
	$("#imagesView #votesWrapper .thumbsDown").live('click', voteDown);
});

// }}}


