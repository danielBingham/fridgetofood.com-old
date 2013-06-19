<?php
class Application_Model_Builder_RecipeSection extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'recipeIngredients' => false,
			'recipeInstructions' => false
		);
	}
	
	public function buildRecipeIngredients(Application_Model_RecipeSection $recipeSection) {
		$recipeSection->setRecipeIngredients(Application_Model_Query_RecipeIngredient::getInstance()->fetchAll(array('recipe_section_id'=>$recipeSection->getRecipeSectionID())));
	}
	
	public function buildRecipeInstructions(Application_Model_RecipeSection $recipeSection) {
		$recipeSection->setRecipeInstructions(Application_Model_Query_RecipeInstruction::getInstance()->fetchAll(array('recipe_section_id'=>$recipeSection->getRecipeSectionID())));
	}
	
	public function buildAll(Application_Model_RecipeSection $recipeSection) {
		$this->build('recipeIngredients', $recipeSection);
		$this->build('recipeInstructions', $recipeSection);
	}
	
}

?>