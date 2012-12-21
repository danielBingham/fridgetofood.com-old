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
    Model: Recipe 
    Table: recipes 
    Description:  Contains all information stored for a recipe.  Represents a single
        recipe from the site.

    Fields:
        id - The images id in the database.
        title - The title of the recipe.
        intro - An introductory paragraph about the recipe or blog teaser.
        url_title - The title sanitized for use in urls.
        source - The name of the source from which the recipe comes.
        source_url - The url of the recipe's source, if it is online.
        blog - The name of the blog from which the recipe comes.
        blog_url - The URL of the post from which the recipe comes.
        user_id - The id of of the user who posted and owns this recipe.
        preparation_time - The time it takes to cook this recipe.
        serves - How much this recipe yields or how many it serves.
        views - The number of views this recipe has received.
        created - A timestamp for the recipe's creation in the database.
        modified - A timestamp recording when the recipe was last modified in the database.
        is_community - A boolean to determine whether this is a community recipe.
        is_deleted - A boolean determining whether this recipe has been deleted.

    Associations:
        User - The User that owns this recipe.
        Images - This recipe's images.   
        Tags - The tags this recipe has been tagged with.
        RecipeSections - The subsections of this recipe.
        RecipeComments - Any comments that have been posted about this recipe.
*/

class Application_Model_Recipe extends Application_Model_Abstract {
    // Model Definition
    public static $_modelName = 'Recipe';
    public static $_fields = array( 
                        'id', 'title','intro', 'url_title', 'source',
                        'source_url', 'blog', 'blog_url', 'user_id',
                        'preparation_time', 'serves', 'views', 'created', 
                        'modified', 'is_community', 'is_deleted');
    public static $_associations = array(
                        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false), 
                        'recipeImages'=>array('type'=>'many', 'class'=>'Application_Model_RecipeImage', 'save'=>false), 
                        'recipeTags'=>array('type'=>'many', 'class'=>'Application_Model_RecipeTag', 'save'=>true),
                        'recipeSections'=>array('type'=>'many', 'class'=>'Application_Model_RecipeSection', 'save'=>true),
                        'recipeComments'=>array('type'=>'many', 'class'=>'Application_Model_RecipeComment', 'save'=>false));
    public static $_virtuals = array('voteTotal', 'numberOfComments');

    public function getRecipeSectionCount() {
       return count($this->recipeSections);
    }
	
}

?>
