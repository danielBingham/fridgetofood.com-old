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
    Model: RecipeIngredient
    Table: recipe_items 
    Description:  Represents a row from the ingredients table
        of a recipe.  Contains information on the amount
        and preparation of a certain ingredient in a recipe.  

    Fields:
        id - The recipe ingredient's id in the database.
        recipe_id - The id of the recipe this RecipeIngredient is attached to.
        recipe_section_id - The id of the section that this RecipeIngredient is listed in.
        ingredient_id - The id of the ingredient that this RecipeIngredient is attached to.
        preparation - The preparation required for this ingredient.
        amount - The amount of this ingredient called for by the recipe.

    Associations:
        ingredient - The ingredient that this RecipeIngredient links to.  
*/

class Application_Model_RecipeIngredient extends Application_Model_Abstract {
    public static $_modelName = 'RecipeIngredient';
    public static $_fields = array('id', 'recipe_id', 'recipe_section_id', 'ingredient_id', 'preparation', 'amount');
    public static $_associations = array(
        'ingredient'=>array('type'=>'one', 'class'=>'Application_Model_Ingredient', 'save'=>false));

}

