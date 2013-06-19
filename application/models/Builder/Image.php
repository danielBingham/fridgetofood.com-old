<?php
class Application_Model_Builder_Image extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'recipe' => false,
			'user' => false,
			'farm' => false,
			'virtualAPI' => false
		);
	}
	
	protected function buildRecipe(Application_Model_Image $image) {
		$recipe = Application_Model_Query_Recipe::getInstance()->getRecipeForImage($image);
		if(!empty($recipe)) {
			$image->setRecipe($recipe);
		}
	}
	
	protected function buildUser(Application_Model_Image $image) {
		$image->setUser(Application_Model_Query_User::getInstance()->get($image->getUserID()));	
	}
	
	protected function buildFarm(Application_Model_Image $image) {
		$image->setFarm(Application_Model_Query_Farm::getInstance()->getFarmForImage($image));
	}
	
	protected function buildVirtualAPI(Application_Model_Image $image) {
		$mapper = new Application_Model_Mapper_Image();
		$mapper->populateVirtualAPI($image);
	}
	
	public function buildAll(Application_Model_Image $image) {
		$this->build('virtualAPI', $image);
		$this->build('user', $image);
		$this->build('recipe', $image);
	}
	
}

?>
