<?PHP

class Application_Model_UserGoogle extends Application_Model_Abstract {
    public static $_modelName = 'UserGoogle';
    public static $_fields = array('id', 'user_id', 'email');
    public static $_associations = array(
        'user'=>array('type'=>'one', 'class'=>'Application_Model_User', 'save'=>false));
}
