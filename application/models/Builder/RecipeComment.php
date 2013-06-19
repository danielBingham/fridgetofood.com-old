<?php
class Application_Model_Builder_RecipeComment extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'user'=>false
		);
	}
	
	protected function buildUser(Application_Model_RecipeComment $recipeComment) {
		$recipeComment->setUser(Application_Model_Query_User::getInstance()->get($recipeComment->getUserID()));
	}
	
	public function buildAll(Application_Model_RecipeComment $recipeComment) {
		$this->build('user', $recipeComment);
	}
	
}

?>