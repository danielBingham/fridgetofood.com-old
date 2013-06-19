<?php
class Application_Model_Builder_Tag extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'user'=>false,
			'recipes'=>false,
			'virtualAPI'=>false
		);
	}
	
	public function buildUser(Application_Model_Tag $tag) {
		
	}
	
	public function buildRecipes(Application_Model_Tag $tag) {
		$tag->setRecipes(Application_Model_Query_Recipe::getInstance()->getRecipesForTag($tag));
	}
	
	public function buildVirtualAPI(Application_Model_Tag $tag) {
		$mapper = new Application_Model_Mapper_Tag();
		$mapper->getRecipeCount($tag);
	}
	
	public function buildAll(Application_Model_Tag $tag) {
		$this->build('virtualAPI', $tag);
		$this->build('recipes', $tag);
		$this->build('user', $tag);
	}
}
?>