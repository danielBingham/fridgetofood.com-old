<?php
class Application_Model_Builder_FarmProduct extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'ingredient' => false
		);
	}
	
	protected function buildIngredient(Application_Model_FarmProduct $farmProduct) {
		$farmProduct->setIngredient(Application_Model_Query_Ingredient::getInstance()->get($farmProduct->getIngredientID()));
	}
	
	public function buildAll(Application_Model_FarmProduct $farmProduct) {
		$this->build('ingredient', $farmProduct);
	}
	
}

?>