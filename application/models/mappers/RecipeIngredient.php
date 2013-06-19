<?php
class Application_Model_Mapper_RecipeIngredient {

	private $_dbTable;

    // {{{ getDbTable():                                                                        public Application_Model_DbTable_RecipeIngredient
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_RecipeIngredient();
		}
		return $this->_dbTable;
	}	

    // }}}
    // {{{ fromDbObject(Application_Model_RecipeIngredient $recipeIngredient, $data):           public void	

	public function fromDbObject(Application_Model_RecipeIngredient $recipeIngredient, $data) {
		$this->fromDbArray($recipeIngredient, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_RecipeIngredient $recipeIngredient, array $data):      public void
	
	public function fromDbArray(Application_Model_RecipeIngredient $recipeIngredient, array $data) {
		$recipeIngredient->setRecipeIngredientID($data['id'])
					->setRecipeID($data['recipe_id'])
					->setRecipeSectionID($data['recipe_section_id'])
					->setIngredientID($data['ingredient_id'])
					->setPreparation(stripslashes($data['preparation']))
					->setAmount(stripslashes($data['amount']));
	}

    // }}}	
    // {{{ toDbArray(Application_Model_RecipeIngredient):                                       public array
	
    public function toDbArray(Application_Model_RecipeIngredient $recipeIngredient) {
		$data = array(
			'recipe_id'=>$recipeIngredient->getRecipeID(),
			'recipe_section_id'=>$recipeIngredient->getRecipeSectionID(),
			'ingredient_id'=>$recipeIngredient->getIngredientID(),
			'preparation'=>$recipeIngredient->getPreparation(),
			'amount'=>$recipeIngredient->getAmount()
		);
		return $data;
	}

    // }}}	

}
?>
