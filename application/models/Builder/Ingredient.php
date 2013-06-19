<?php
class Application_Model_Builder_Ingredient extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'images'=>false,
			'virtualAPI'=>false
		);
	}
	
	protected function buildImages(Application_Model_Ingredient $ingredient) {
		$ingredient->setImages(Application_Model_Query_Image::getInstance()->getImagesForIngredient($ingredient));
	}
	
	protected function buildVirtualAPI(Application_Model_Ingredient $ingredient) {
		$mapper = new Application_Model_Mapper_Ingredient();
		$mapper->populateVirtualAPI($ingredient);
	}
	
	public function buildAll(Application_Model_Ingredient $ingredient) {
		$this->build('virtualAPI', $ingredient);
		$this->build('images', $ingredient);
	}
}
?>