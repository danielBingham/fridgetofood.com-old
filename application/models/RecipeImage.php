<?PHP

class Application_Model_RecipeImage extends Application_Model_Abstract {
    public static $_modelName = 'RecipeImage';
    public static $_fields = array ('id', 'recipe_id', 'image_id');
    public static $_associations = array(
        'recipe'=>array('type'=>'one', 'class'=>'Application_Model_Recipe', 'save'=>false),
        'image'=>array('type'=>'one', 'class'=>'Application_Model_Image', 'save'=>false));

}

?>
