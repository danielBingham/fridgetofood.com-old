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
    Model: RecipeSection
    Table: recipe_sections 
    Description: Represents a subsection of a recipe containing certain ingredients
        and instructions.  Could be a dressing, or a sauce or just a stage of the recipe.

    Fields:
        id - The section's id in the database.
        recipe_id - The id of the recipe to which this section belongs.
        title - The title of the section.
        position - This sections position among the other sections, used to order them.
        base - Is this the main or primary section?  Boolean.

    Associations:
        recipeIngredients - The ingredients this section contains.
        recipeInstructions - The instructions that this section contains.
*/
class Application_Model_RecipeSection extends Application_Model_Abstract {
    public static $_modelName = 'RecipeSection';
    public static $_fields = array('id', 'recipe_id', 'title', 'position', 'base');
    public static $_associations = array(
        'recipeIngredients'=>array('type'=>'many', 'class'=>'Application_Model_RecipeIngredient', 'save'=>true),
        'recipeInstructions'=>array('type'=>'many', 'class'=>'Application_Model_RecipeInstructions', 'save'=>true)); 


    // Model Methods
    // {{{ hasIngredients():                                                public boolean 
    
    public function hasIngredients() {

        if($this->getIngredientCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
   
     // }}}
    // {{{ hasInstructions():                                               public boolean 

    public function hasInstructions() {
        if($this->getInstructionCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // }}}	

}
