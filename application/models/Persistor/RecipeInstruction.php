<?php
/**
*
*/
class Application_Model_Persistor_RecipeInstruction extends Application_Model_Persistor_Abstract {
    private $_mapper;
    
    // {{{ getMapper():                                                     protected Application_Model_Mapper_RecipeInstruction
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_RecipeInstruction();
        }
        return $this->_mapper;
    }

    // }}}
    // {{{ save(Application_Model_RecipeInstruction $instruction):          public void
    
    public function save(Application_Model_RecipeInstruction $instruction) {
        if($instruction->getRecipeInstructionID()) {
            $this->update($instruction);
        } else {
            $this->insert($instruction);
        } 
    }

    // }}}

    // {{{ delete(Application_Model_RecipeInstruction $instruction):        public void

    public function delete(Application_Model_RecipeInstruction $instruction) {
        parent::deleteRaw($instruction->getRecipeInstructionID());
    }

    // }}}
    // {{{ insert(Application_Model_RecipeInstruction $instruction):        protected void

    protected function insert(Application_Model_RecipeInstruction $instruction) {
        $data = $this->getMapper()->toDbArray($instruction);
        $instruction->setRecipeInstructionID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_RecipeInstruction $instruction):        protected void

    protected function update(Application_Model_RecipeInstruction $instruction) {
        $data = $this->getMapper()->toDbArray($instruction);
        parent::updateRaw($data, $instruction->getRecipeInstructionID()); 
    }

    // }}}

}
?>

