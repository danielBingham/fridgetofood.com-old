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
    Model: Image
    Table: images
    Description:  Contains all information for an image stored on the server.  The image
    can be attached to a user or a recipe.  

    Fields:
        id - The images id in the database.
        userID - The id of the user that uploaded the image.
        width - The base width of the full image.
        height - The base height of the full image.
        views - The number of views the image has received.
        created - A timestamp representing when the image database row was created.
        modified - A timestamp representing when this image's database row was last updated. 

    Associations:
        recipe - The recipe to which this image is attached.
        user - The user that uploaded and owns the image.

*/
class Application_Model_Image extends Application_Model_Abstract {
    public static $_modelName = 'Image';
    public static $_fields = array('id', 'user_id', 'width', 'height', 'views', 'created', 'modified'), 
    public static $_associations = array(
        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false));
    public static $_virtuals = array('votes');

    /**
        Determine whether this image has a related file stored in the image directory.  Assume
        a size of medium if no size given.  

        Possible sizes: 
            small - 100px x 100px, 
            medium - 300px x 300px, 
            large - 1024px x 780px, 
            full - $this->width x $this->height
    */	
	public function fileExists($size='medium') {
		$path = '/srv/www/img.fridgetofood.com/' . $size . '/' . $this->id . '.jpg';
		return file_exists($path);
		
	}

}

