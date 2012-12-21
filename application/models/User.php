<?php

class Application_Model_User extends Application_Model_Abstract {
    public static $_modelName = 'User';
    public static $_fields = array(
        'id', 'email', 'password', 'display_name', 'reputation', 'website',
        'website_url', 'import_blog', 'about', 'image_id', 'created', 'seen',
        'notified', 'modified');
    public static $_associations = array(
        'recipes'=>array('type'=>'many', 'class'=>'Application_Model_Recipe', 'save'=>false),
        'images'=>array('type'=>'many', 'class'=>'Application_Model_RecipeImage', 'save'=>false),
        'image'=>array('type'=>'one', 'class'=>'Application_Model_Image', 'save'=>true),
        'ribbons'=>array('type'=>'many', 'class'=>'Application_Model_UserRibbon', 'save'=>false),
        'permissions'=>array('type'=>'many', 'class'=>'Application_Model_UserPermission', 'save'=>false));
    public static $_virtuals = array('recipeCount');

}
