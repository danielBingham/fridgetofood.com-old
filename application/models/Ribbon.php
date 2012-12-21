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
    Model: Ribbon 
    Table: ribbons 
    Description: Represents the ribbons that users earn for accomplishing
        certain goals.  The code that handles when a ribbon is earned
        can be found in application/services/Ribbon 

    Fields:
        id - The ribbon's id in the database.
        name - The ribbon's name, used as an identifier in code and in the database.
        display_name - The name that is displayed for the ribbon.
        description - A description of the ribbon. 
        type - The type of ribbon: green, white, red or blue.
        repeatable - Can more than one of this ribbon be earned? Boolean.

    Associations:

*/

class Application_Model_Ribbon extends Application_Model_Abstract {
    public static $_modelName = 'Ribbon';
    public static $_fields = array('id', 'name', 'display_name', 'description', 'type', 'repeatable');
    public static $_associations = array(
        'userRibbons'=>array('type'=>'many', 'classes'=>'Application_Model_UserRibbon', 'save'=>'yes'));

 
    // {{{ getNumberEarned():                                               public int
	
	public function getNumberEarned() {
		return Application_Model_Query_Ribbon::getInstance()->getNumberEarned($this);
	}

    // }}}


}

?>
