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
    Model: Tag
    Table: tags 
    Description:  A wrapper for a single tag.  

    Fields:
        id - The tag's id in the database.
        name - The tag's name.
        type - The type of tag.  (general, course, diet, allergen, cuisine)
        description - A short description of the tag.
        revision - The id of the current revision of the tag.
        user_id - The id of the user who owns this revision.
        created - A timestamp recording when the tag was created.
        modified - A timestamp recording when the tag was last modified.  

    Associations:
        User - The user who owns this revision.
        Recipes - The recipes that are tagged with this tag.
*/
class Application_Model_Tag extends Application_Model_Abstract {
    public static $_modelName = 'Tag';
    public static $_fields = array('id', 'name', 'type', 'description', 'revision', 'user_id', 'created', 'modified');
    public static $_associations = array(
        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false),
        'recipeTags'=>array('type'=>'many', 'class'=>'Application_Model_RecipeTag', 'save'=>false));
}
