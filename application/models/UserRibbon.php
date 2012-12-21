<?php

class Application_Model_UserRibbon extends Application_Model_Abstract  {
    public static $_modelName = 'UserRibbon';
    public static $_fields = array('id', 'ribbon_id', 'user_id', 'created', 'modified');
    public static $_associations = array(
        'ribbon'=>array('type'=>'one', 'class'=>'Application_Model_Ribbon', 'save'=>false));
}
