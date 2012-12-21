<?php
/**
*
*/
class Application_Model_Persistor_Recipe extends Application_Model_Persistor_Abstract {
    

    // {{{ save($recipe):                                                   public void
    
    public function save($recipe) {
        if($recipe->id) {
            $recipe->modified = Zend_Date::now();
        } else {
            $recipe->created = Zend_Date::now();
            $recipe->modified = Zend_Date::now();
        }
        parent::save($recipe);
   }

    // }}}

}
?>
