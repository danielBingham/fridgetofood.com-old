<?php
/**
*
*/
class Application_Model_Persistor_RecipeComment extends Application_Model_Persistor_Abstract {

    // {{{ save(Application_Model_RecipeComment $recipeComment):            public void
    
    public function save(Application_Model_RecipeComment $recipeComment) {
        if($recipeComment->getRecipeCommentID()) {
            $recipeComment->setCreated(Zend_Date::now());
            $recipeComment->setModified(Zend_Date::now());
        } else {
            $recipeComment->setModified(Zend_Date::now());
        }
        parent::save($recipeComment);
    }

    // }}}

}
?>
