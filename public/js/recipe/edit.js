/**
* File: add.js
*
*   Javascript that will be applied to the recipe/add page of Fridge to Food to
*   handle dynamic page elements.  Contains code to:
*       - add and remove sections, ingredients, and instructions
*       - suggest ingredients
*       - validate form
*/
var numberOfIngredientSections; // The number of Ingredient sections.
var numberOfInstructionSections; // The number of Instruction sections.
var numberOfIngredients = []; // Array containing the number of ingredients in each section.
var numberOfInstructions = []; // Array containing the number of instructions in each section.
var instructionNumber = []; // Array containing the current max number of instruction displayed.  Different from the internal instruction counter.

// Utility functions
// {{{ getID(jqObject)

/**
 * Assuming divs that are assigned integer ids of the format <type>_<id>,
 * this function will parse the integer ID off of the HTML id and return it
 * as an int.
 * 
 * @param jqObject
 * @returns
 */
function getID(jqObject) {
	return parseInt(jqObject.attr('id').substr(jqObject.attr('id').lastIndexOf('_')+1));
}

// }}}
// {{{ decrementID(jqObject)

/**
 * Given a jquery object with an id of the format <type>_<id>,
 * decrements the id.
 * 
 * @param jqObject
 */
function decrementID(jqObject) {
	id = getID(jqObject)-1;
	jqObject.attr('id', jqObject.attr('id').substr(0, jqObject.attr('id').lastIndexOf('_'))+'_'+id);
}

// }}}

// Event Functions
// {{{ addIngredientSection(e)

/**
 * Add a new Ingredient section copied from the clonable section and inserted
 * just ahead of it.  Assign a new id to it and increment the number of
 * ingredient sections.
 */
function addIngredientSection(e) {
    var newSection = $('.ingredientSection.clonable').clone();

   
    newSection.removeClass('clonable'); 
    newSection.attr('id', 'ingredientSection_' + numberOfIngredientSections);
    numberOfIngredients[numberOfIngredientSections] = 0;

    var innerHTML = newSection.html();
    innerHTML = innerHTML.replace(/S#/g, numberOfIngredientSections);
    newSection.html(innerHTML);
    
    numberOfIngredientSections++;

    addIngredient(null, newSection);
    
    $('#ingredients').append(newSection);
}

// }}}
// {{{ deleteIngredientSection(e)

function deleteIngredientSection(e) {
	var removedID = getID($(this).parents(".ingredientSection"));
	var jqNumberOfIngredientSections = $('input[name="numberOfIngredientSections"]');
	jqNumberOfIngredientSections.val(parseInt(jqNumberOfIngredientSections.val())-1);
	$(this).parents(".ingredientSection").remove();
}

// }}}
// {{{ addIngredient(e)
 
/**
 * Add an ingredient to an ingredient section.  We can assume the '+ add an ingredient'
 * link that triggers this function exists in the section we want to add the ingredient
 * to.  We can also assume this function is running in the context of a jQuery event
 * handler. Thus, $(this) refers to the anchor element for the '+ add an ingredient' link.
 * 
 * @param e
 */
function addIngredient(e, parentS) {
	var parentSection;
    if(typeof(parentS) == 'undefined') {    
         parentSection = $(this).parents(".ingredientSection");
    } else {
        parentSection = parentS;
    }
    
    var thisSection = getID(parentSection);	
    var newIngredient = $('.ingredient.clonable').clone();

    newIngredient.attr('id', 'ingredientSection' + thisSection + 'ingredient_'+numberOfIngredients[thisSection]);
    newIngredient.removeClass('clonable');

    var innerHTML = newIngredient.html();
    innerHTML = innerHTML.replace(/S#/g, thisSection);
    innerHTML = innerHTML.replace(/I#/g, numberOfIngredients[thisSection]);
    newIngredient.html(innerHTML);

    numberOfIngredients[thisSection]++;
    
    parentSection.find(".section_clear").before(newIngredient);
}

// }}}
// {{{ deleteIngredient(e)

function deleteIngredient(e) {
	$(this).parents(".ingredient").remove();
}

// }}}
// {{{ addInstructionSection(e)

/**
 * Add a new Instruction section copied from the clonable section and inserted
 * just ahead of it.  Assign a new id to it and increment the number of
 * instruction sections.
 */
function addInstructionSection(e) {
	var newSection = $(".instructionSection.clonable").clone();
   
    newSection.removeClass('clonable');
    newSection.attr('id', 'instructionSection_' + numberOfInstructionSections); 
    numberOfInstructions[numberOfInstructionSections] = 0;
    instructionNumber[numberOfInstructionSections] = 1;

    var innerHTML = newSection.html();
    innerHTML = innerHTML.replace(/S#/g, numberOfInstructionSections);
    newSection.html(innerHTML);

    numberOfInstructionSections++;

    addInstruction(null, newSection);

    $('#instructions').append(newSection);
}

// }}}
// {{{ deleteInstructionSection(e)

function deleteInstructionSection(e) {
	$(this).parents(".instructionSection").remove();
}

// }}}
// {{{ addInstruction(e)

function addInstruction(e, parentS) {
	var parentSection;
    if(typeof(parentS) == 'undefined') {    
         parentSection = $(this).parents(".instructionSection");
    } else {
        parentSection = parentS;
    }
    
    var thisSection = getID(parentSection);	
    var newInstruction = $('.instruction.clonable').clone();

    newInstruction.attr('id', 'instructionSection' + thisSection + 'instruction_'+numberOfInstructions[thisSection]);
    newInstruction.removeClass('clonable');

    var innerHTML = newInstruction.html();
    innerHTML = innerHTML.replace(/S#/g, thisSection);
    innerHTML = innerHTML.replace(/I#/g, numberOfInstructions[thisSection]);
    innerHTML = innerHTML.replace(/N#/g, instructionNumber[thisSection]);
    newInstruction.html(innerHTML);

    instructionNumber[thisSection]++;
    numberOfInstructions[thisSection]++;
    
    parentSection.find(".section_clear").before(newInstruction);
}

// }}}
// {{{ deleteInstruction(e)

function deleteInstruction(e) {
    var instruction = $(this).parents(".instruction");
    var removedNumber = parseInt(instruction.children(".numberValue").val());
    var thisSection = getID($(this).parents(".instructionSection"));

    instruction.siblings(".instruction").each(function() {
        var number = parseInt($(this).children(".numberValue").val());
        if(number > removedNumber) {
            $(this).children(".numberValue").val(number-1);
            $(this).children(".number").html((number-1) + ".");
        } 
    });

    instructionNumber[thisSection] = instructionNumber[thisSection]-1;
    $(this).parents(".instruction").remove();	
}

// }}}

// MAIN 
//	Includes assignments of functions to their events.
// {{{ $(document).ready(function() {...});
$(document).ready(function() {
	var submitted = false;

    // {{{ Populate the counter variables.
    numberOfIngredientSections = parseInt($("#numberOfIngredientSections").html());
    for(var i=0; i < numberOfIngredientSections; i++) {
        numberOfIngredients[i] = parseInt($("#numberOfIngredients_" + i).html());
    }
    numberOfInstructionSections = parseInt($("#numberOfInstructionSections").html());
    for(var i=0; i < numberOfInstructionSections; i++) {
        numberOfInstructions[i] = parseInt($("#numberOfInstructions_" + i).html());
    }
    for(var i=0; i < numberOfInstructionSections; i++) {
        instructionNumber[i] = numberOfInstructions[i]+1;
    }
    // }}}

	
	$("#contributeAdd").submit(function(e) {
		submitted = true;
	});
	
	$(window).bind("beforeunload", function(e) {
		if(submitted != true) {
			return "If you leave this page you will lose your changes to this recipe and it will not be submitted.";
		}
	});
	
	
	$(".addIngredientSection").live('click', addIngredientSection);
	$(".deleteIngredientSection").live('click', deleteIngredientSection);

	$(".addIngredient").live('click', addIngredient);
	$(".ingredient .delete").live('click', deleteIngredient);

	$(".addInstructionSection").live('click', addInstructionSection);
	$(".deleteInstructionSection").live('click', deleteInstructionSection);
	
	$(".addInstruction").live('click', addInstruction);
	$(".instruction .delete").live('click', deleteInstruction);
	
    $(".sectionTitle input").live('keyup', function(e) {
        var section = $(this).parents(".section");
        var header = section.children(".subheader");
        var title = header.children(".title");
        title.html($(this).val());
    });

});
// }}}
