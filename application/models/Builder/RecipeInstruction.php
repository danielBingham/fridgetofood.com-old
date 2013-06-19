<?php
class Application_Model_Builder_RecipeInstruction extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->haveBuilt = array();
	}
	
	public function buildAll(Application_Model_RecipeInstruction $recipeInstruction) { }
}
?>