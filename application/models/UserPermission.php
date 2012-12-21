<?php

class Application_Model_UserPermission extends Application_Model_Abstract  {
    public static $_modelName = 'UserPermission';
    public static $_fields = array('id', 'permission_id', 'user_id', 'created');
    public static $_associations = array(
        'permission'=>array('type'=>'one', 'class'=>'Application_Model_Permission', 'save'=>false),
        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false));

}
