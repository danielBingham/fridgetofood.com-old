<?php
class Application_Model_Builder_RecipeIngredient extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'ingredient' => false
		);
	}
	
	protected function buildIngredient(Application_Model_RecipeIngredient $recipeIngredient) {
		$recipeIngredient->setIngredient(Application_Model_Query_Ingredient::getInstance()->get($recipeIngredient->getIngredientID()));
	}
	
	public function buildAll(Application_Model_RecipeIngredient $recipeIngredient) {
		$this->build('ingredient', $recipeIngredient);
	}
	
}

?>