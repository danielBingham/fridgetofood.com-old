/**
* Javascript used on the recipe view page.  Handles voting and commenting.
*
*/

// Voting
// {{{ voteUp(e)

function voteUp(e) {
    e.preventDefault();
    if($("#recipeView #votesWrapper .thumbsUp").hasClass('highlight') || $("#recipeView #votesWrapper .thumbsDown").hasClass('highlight')) {
        return;
    }

    var input = 'id/' + $("#recipeView #data").attr('value');
    input += '/vote/1';
    
    if(input == 'false') {
        $("#blackout").css('display', 'block');
        $("#signup").css('display', 'block');
        e.preventDefault();
        return;
    }

    $.ajax({
        type: "GET",
		url: "/recipe/vote/"+input,
		success: function(data){
		    $("#recipeView #votesWrapper .thumbsUp").addClass('highlight');
		    $("#recipeView #votesWrapper #votes .voteTally").html(data);
	    }
    });
}

// }}}
// {{{ voteDown(e)

function voteDown(e) {
    e.preventDefault();
    if($("#recipeView #votesWrapper .thumbsUp").hasClass('highlight') || $("#recipeView #votesWrapper .thumbsDown").hasClass('highlight')) {
        return;
    }

    var input = 'id/' + $("#recipeView #data").attr('value');
    input += '/vote/-1';
    
    if(input == 'false') {
        $("#blackout").css('display', 'block');
        $("#signup").css('display', 'block');
        e.preventDefault();
        return;
    }
		
    $.ajax({
		type: "GET",
	    url: "/recipe/vote/"+input,
		success: function(data){
		    $("#recipeView #votesWrapper .thumbsDown").addClass('highlight');
		    $("#recipeView #votesWrapper #votes .voteTally").html(data);
		}
    });
}

// }}}

// Commenting

// {{{ editComment(e)

function editComment(e) {
    if($(this).html() == 'Edit') {
        $(this).html('Finish Editing');
        var id = $(this).parents('.comment').attr('id');
        var input = 'id='+id;

        $.ajax({
            type: "POST",
            url: "/recipe/edit-comment/stage/get",
            data: input,
            success: function(data) {
                $("#"+id+' .commentContent').html('<textarea>'+data+'</textarea>');
            }
        });
			
    }
    else {
        $(this).html('Edit');
        var id = $(this).parents('.comment').attr('id');
        var input = 'id='+id+'&content='+$(this).parents('.comment').find('.commentContent textarea').val();
        $.ajax({
            type: "POST",
            url: "/recipe/edit-comment/stage/set",
            data: input,
            success: function(data) {
                $("#"+id+" .commentContent").html(data);
            }
        });
    }
}

// }}}
// {{{ deleteComment(e)

function deleteComment(e) {	
    var id = $(this).parents('.comment').attr('id');
    var input = 'id='+id;

    $.ajax({
        type: "POST",
        url: "/recipe/delete-comment",
        data: input,
        success: function(data) {
            $("#"+id).remove();
        }
    });
}

// }}}

// {{{ $(document).ready();

/**
* Assign the actions.
*/
$(document).ready(function() {
	$("#recipeView #votesWrapper .thumbsUp").live('click', voteUp);
	$("#recipeView #votesWrapper .thumbsDown").live('click', voteDown);
	$(".comment .controls .delete").live('click', deleteComment); 
	$(".comment .controls .edit").live('click', editComment); 
});

// }}}


