<?php
/*
 * Copyright:
 *		Copyright (C) 2009-2012 Daniel Bingham (http://www.theroadgoeson.com)
 *
 * License:
 *
 * This software is licensed under the MIT Open Source License which reads as
 * follows:
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
 * USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information see here: http://www.opensource.org/licenses/mit-license.php
 */

/**
    Model: RecipeInstruction 
    Table: recipe_instructions 
    Description:  Represents a single step's instruction for a recipe.  

    Fields:
        id - The instruction's id in the database.
        recipe_id - The id of the recipe to which this instruction belongs.
        recipe_section_id - The id of the section to which this instruction belongs.
        number - Which instruction in this?  Used to order the instructions.
        content - The text of the instruction.

    Associations:

*/
class Application_Model_RecipeInstruction extends Application_Model_Abstract {
    public static $_modelName = 'RecipeInstruction';
    public static $_fields = array('id', 'recipe_id', 'recipe_section_id', 'number', 'content');

}

?>
