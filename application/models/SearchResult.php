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
    Model: SearchResult 
    Table: search_results 
    Description: Represents a single result from a particular search. 

    Fields:
        id - The images id in the database.
        search_id - The id of the search this result belongs to.
        recipe_id - The id of the recipe that this result represents.
        relevance - The relevance of that recipe to the search.

    Associations:
        Search - The search that this result belongs to.
        Recipe - The recipe that was found in this result.
*/
class Application_Model_SearchResult extends Application_Model_Abstract {
    public static $_modelName = 'SearchResult';
    public static $_fields = array('id', 'search_id', 'recipe_id', 'relevance');
    public static $_associations = array(
        'search'=>array('type'=>'one', 'class'=>'Application_Model_Search', 'save'=>false),
        'recipe'=>array('type'=>'one', 'class'=>'Application_Model_Search', 'save'=>false));
}
