<?php

/**
*
*/
class Application_Model_Persistor_Ingredient extends Application_Model_Persistor_Abstract {
    private $_mapper;
    
    // {{{ getMapper():                                                     protected Application_Model_Mapper_Ingredient
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_Ingredient();
        }
        return $this->_mapper;
    }

    // }}}
    // {{{ save(Application_Model_Ingredient $ingredient):                  public void 
    
    public function save(Application_Model_Ingredient $ingredient) {
        if($ingredient->getIngredientID()) {
            $this->update($ingredient);
        } else {
            $this->insert($ingredient);
        }
    }

    // }}}
  
    // {{{ delete(Application_Model_Ingredient $ingredient):                public void
    
    public function delete(Application_Model_Ingredient $ingredient) {
        parent::deleteRaw($ingredient->getIngredientID());
    }

    // }}}  
    // {{{ insert(Application_Model_Ingredient $ingredient):                protected void 

    protected function insert(Application_Model_Ingredient $ingredient) {
        $data = $this->getMapper()->toDbArray($ingredient);
        $ingredient->setIngredientID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_Ingredient $ingredient):                protected void 

    protected function update(Application_Model_Ingredient $ingredient) {
        $data = $this->getMapper()->toDbArray($ingredient);
        parent::updateRaw($data, $ingredient->getIngredientID()); 
    }

    // }}}

}
?>
