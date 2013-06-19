<?php
class Application_Model_Mapper_RecipeSection {
	
	private $_dbTable;
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_RecipeSection();
		}
		return $this->_dbTable;
	}	
	
	public function fromDbObject(Application_Model_RecipeSection $recipeSection, $data) {
		$this->fromDbArray($recipeSection, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_RecipeSection $recipeSection, array $data) {
		$recipeSection->setRecipeSectionID($data['id'])
					->setRecipeID($data['recipe_id'])
					->setTitle($data['title'])
					->setPosition($data['position'])
					->setMain(($data['base']==1 ? true : false));
	}
	
	public function toDbArray(Application_Model_RecipeSection $recipeSection) {
		$data = array(
			'recipe_id'=>$recipeSection->getRecipeID(),
			'title'=>$recipeSection->getTitle(),
			'position'=>$recipeSection->getPosition(),
			'base'=>($recipeSection->isMain() ? 1 : 0)
		);
		return $data;
	}
	
}
?>
