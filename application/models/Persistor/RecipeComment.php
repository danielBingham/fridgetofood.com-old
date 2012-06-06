<?php
/**
*
*/
class Application_Model_Persistor_RecipeComment extends Application_Model_Persistor_Abstract {
    private $_mapper;

    // {{{ getMapper():                                                     public Application_Model_Mapper_RecipeComment

    public function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_RecipeComment();
        }
        return $this->_mapper;
    }
    
    // }}}

    // {{{ save(Application_Model_RecipeComment $recipeComment):            public void
    
    public function save(Application_Model_RecipeComment $recipeComment) {
        if($recipeComment->getRecipeCommentID()) {
            $this->update($recipeComment);
        } else {
            $this->insert($recipeComment); 
        }
    }

    // }}}
   
    // {{{ delete(Application_Model_RecipeComment $recipeComment):          public void

    public function delete(Application_Model_RecipeComment $recipeComment) {
        parent::deleteRaw($recipeComment->getRecipeCommentID());
    }

    // }}} 
    // {{{ insert(Application_Model_RecipeComment $recipeComment):          public void

    public function insert(Application_Model_RecipeComment $recipeComment) {
        $recipeComment->setCreated(Zend_Date::now());
        $recipeComment->setModified(Zend_Date::now());
 
        $data = $this->getMapper()->toDbArray($recipeComment);
        $recipeComment->setRecipeCommentID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_RecipeComment $recipeComment):          public void

    public function update(Application_Model_RecipeComment $recipeComment) {
        $recipeComment->setModified(Zend_Date::now());
    
        $data = $this->getMapper()->toDbArray($recipeComment);
        parent::updateRaw($data, $recipeComment->getRecipeCommentID());
    }
    
    // }}}

}
?>
