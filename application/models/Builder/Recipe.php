<?php
class Application_Model_Builder_Recipe extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'user'=>false,
			'images'=> false,
			'recipeSections'=> false,
			'tags' => false,
			'recipeComments' => false,
			'virtualAPI' => false
		);
	}

	protected function buildUser(Application_Model_Recipe $recipe) {
		$recipe->setUser(Application_Model_Query_User::getInstance()->get($recipe->getUserID()));	
	}
	
	protected function buildImages(Application_Model_Recipe $recipe) {
		$recipe->setImages(Application_Model_Query_Image::getInstance()->getImagesForRecipe($recipe->getRecipeID()));
		
	}
	
	protected function buildRecipeSections(Application_Model_Recipe $recipe) {
		$recipe->setRecipeSections(Application_Model_Query_RecipeSection::getInstance()->fetchAll(array('recipe_id'=>$recipe->getRecipeID())));
	}
	
	protected function buildTags(Application_Model_Recipe $recipe) {
		$recipe->setTags(Application_Model_Query_Tag::getInstance()->getTagsForRecipe($recipe->getRecipeID()));
	}
	
	protected function buildRecipeComments(Application_Model_Recipe $recipe) {
		$recipe->setRecipeComments(Application_Model_Query_RecipeComment::getInstance()->fetchAll(array('recipe_id'=>$recipe->getRecipeID())));
	}
	
	protected function buildVirtualAPI(Application_Model_Recipe $recipe) {
		$mapper = new Application_Model_Mapper_Recipe();
		$mapper->updateVirtualAPI($recipe);
	}
	
	
	public function buildAll(Application_Model_Recipe $recipe) {
		$this->build('virtualAPI', $recipe);
		$this->build('user', $recipe);
		$this->build('images', $recipe);
		$this->build('recipeSections', $recipe);
		$this->build('tags', $recipe);
		$this->build('recipeComments', $recipe);
	}
	
	
}

?>
