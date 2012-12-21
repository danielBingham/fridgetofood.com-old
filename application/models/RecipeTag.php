<?PHP

class Application_Model_RecipeTag extends Application_Model_Abstract {
    public static $_modelName = 'RecipeTag';
    public static $_fields = array('id', 'recipe_id', 'tag_id');
    public static $_associations = array(
        'recipe'=>array('type'=>'one', 'class'=>'Application_Model_Recipe', 'save'=>false),
        'tag'=>array('type'=>'one', 'class'=>'Application_Model_Tag', 'save'=>false));

}

?>
