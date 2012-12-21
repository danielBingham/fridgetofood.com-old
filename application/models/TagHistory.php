<?php

class Application_Model_TagHistory extends Application_Model_Abstract  {
    public static $_modelName = 'TagHistory';
    public static $_fields = array('id', 'tag_id', 'name', 'type', 'description', 'edit_time', 'revision', 'user_id');
    public static $_associations = array(
        'tag'=>array('type'=>'one', 'class'=>'Application_Model_Tag', 'save'=>false),
        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false));

}
