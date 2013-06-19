<?php
/**
*
*/
class Application_Model_Persistor_RecipeSection extends Application_Model_Persistor_Abstract {
    private $_mapper;

    // {{{ getMapper():                                                     protected Application_Model_Mapper_RecipeSection 

    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_RecipeSection();
        }
        return $this->_mapper;
    }

    // }}}

    // {{{ save(Application_Model_RecipeSection $section):                  public void 
    
    public function save(Application_Model_RecipeSection $section) {
        if($section->getRecipeSectionID()) {
            $this->update($section);
        } else {
            $this->insert($section); 
        }
    
        $persistor = new Application_Model_Persistor_RecipeIngredient();
        foreach($section->getRecipeIngredients() as $ingredient) {
            $ingredient->setRecipeID($section->getRecipeID());
            $ingredient->setRecipeSectionID($section->getRecipeSectionID());
            $persistor->save($ingredient);
            
        }
        unset($persistor);
        
        $persistor = new Application_Model_Persistor_RecipeInstruction();
        foreach($section->getRecipeInstructions() as $instruction) {
            $instruction->setRecipeID($section->getRecipeID());
            $instruction->setRecipeSectionID($section->getRecipeSectionID());
            $persistor->save($instruction);
        }
        unset($persistor);
    }

    // }}} 
    
    // {{{ delete(Application_Model_RecipeSection $section):                public void 

    public function delete(Application_Model_RecipeSection $section) {
        $persistor = new Application_Model_Persistor_RecipeIngredient();
        foreach($section->getRecipeIngredients() as $ingredient) {
            $persistor->delete($ingredient);
        }
        unset($persistor);

        $persistor = new Application_Model_Persistor_RecipeInstruction();
        foreach($section->getRecipeInstructions() as $instruction) {
            $persistor->delete($instruction);
        }
        unset($persistor);
        
        parent::deleteRaw($section->getRecipeSectionID());
    }

    // }}}
    // {{{ insert(Application_Model_RecipeSection $section):                protected void

    protected function insert(Application_Model_RecipeSection $section) {
        $data = $this->getMapper()->toDbArray($section);
        $section->setRecipeSectionID(parent::insertRaw($data));
    }
    
    // }}}
    // {{{ update(Application_Model_RecipeSection $section):                protected void

    protected function update(Application_Model_RecipeSection $section) {
        $data = $this->getMapper()->toDbArray($section);
        parent::updateRaw($data, $section->getRecipeSectionID()); 
    }
    
    // }}} 
}
?>
