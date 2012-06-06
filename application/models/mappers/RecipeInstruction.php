<?php
class Application_Model_Mapper_RecipeInstruction {
	
	private $_dbTable;

    // {{{ getDbTable():                                                                            public Application_Model_DbTable_RecipeInstruction
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_RecipeInstruction();
		}
		return $this->_dbTable;
	}	

    // }}}
    // {{{ fromDbObject(Application_Model_RecipeInstruction $recipeInstruction, $data):             public void
	
	public function fromDbObject(Application_Model_RecipeInstruction $recipeInstruction, $data) {
		$this->fromDbArray($recipeInstruction, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_RecipeInstruction $recipeInstruction, array $data):        public void
	
	public function fromDbArray(Application_Model_RecipeInstruction $recipeInstruction, array $data) {
		$recipeInstruction->setRecipeInstructionID($data['id'])
					->setRecipeID($data['recipe_id'])
					->setRecipeSectionID($data['recipe_section_id'])
					->setNumber($data['number'])
					->setContent(stripslashes($data['content']));
	}

    // }}}
    // {{{ toDbArray(Application_Model_RecipeInstruction $recipeInstruction):                       public array
	
	public function toDbArray(Application_Model_RecipeInstruction $recipeInstruction) {
		$data = array(
			'recipe_id'=>$recipeInstruction->getRecipeID(),
			'recipe_section_id'=>$recipeInstruction->getRecipeSectionID(),
			'number'=>$recipeInstruction->getNumber(),
			'content'=>$recipeInstruction->getContent()
		);
		return $data;
	}

    // }}}	
}
?>
