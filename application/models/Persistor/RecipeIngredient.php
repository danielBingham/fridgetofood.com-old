<?php
/**
*
*/
class Application_Model_Persistor_RecipeIngredient extends Application_Model_Persistor_Abstract {
    private $_mapper;
    
    // {{{ getMapper():                                                     protected Application_Model_Mapper_RecipeIngredient
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_RecipeIngredient();
        }
        return $this->_mapper;
    }

    // }}}
    // {{{ save(Application_Model_RecipeIngredient $ingredient):            public void
    
    public function save(Application_Model_RecipeIngredient $ingredient) {
        $persistor = new Application_Model_Persistor_Ingredient();
        $persistor->save($ingredient->getIngredient());
        $ingredient->setIngredientID($ingredient->getIngredient()->getIngredientID());        
 
        if($ingredient->getRecipeIngredientID()) {
            $this->update($ingredient);
        } else {
            $this->insert($ingredient);
        }
    }

    // }}}
    
    // {{{ delete(Application_Model_RecipeIngredient $ingredient):          public void
    
    public function delete(Application_Model_RecipeIngredient $ingredient) {
        parent::deleteRaw($ingredient->getRecipeIngredientID());
    }

    // }}}
    // {{{ insert(Application_Model_RecipeIngredient $ingredient):          protected void

    protected function insert(Application_Model_RecipeIngredient $ingredient) {
        $data = $this->getMapper()->toDbArray($ingredient);
        $ingredient->setRecipeIngredientID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_RecipeIngredient $ingredient):          protected void

    protected function update(Application_Model_RecipeIngredient $ingredient) {
        $data = $this->getMapper()->toDbArray($ingredient);
        parent::updateRaw($data, $ingredient->getRecipeIngredientID()); 
    }

    // }}}

}
?>
