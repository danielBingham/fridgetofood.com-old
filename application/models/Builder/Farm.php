<?php
class Application_Model_Builder_Farm extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'products'=>false,
			'tags'=>false,
			'images'=>false,
			'markets'=>false,
			'virtualAPI'=>false
		);
	}
	
	protected function buildProducts(Application_Model_Farm $farm) {
		$farm->setProducts(Application_Model_Query_FarmProduct::getInstance()->fetchAll(array('farm_id'=>$farm->getFarmID())));
	}
	
	protected function buildTags(Application_Model_Farm $farm) {
		$farm->setTags(Application_Model_Query_Tag::getInstance()->getTagsForFarm($farm->getFarmID()));
	}
	
	protected function buildImages(Application_Model_Farm $farm) {
		$farm->setImages(Application_Model_Query_Image::getInstance()->getImagesForFarm($farm->getFarmID()));
	}
	
	protected function buildMarkets(Application_Model_Farm $farm) {
		
	}
	
	protected function buildComments(Application_Model_Farm $farm) {
		$farm->setComments(Application_Model_Query_FarmComment::getInstance()->fetchAll(array('farm_id'=>$farm->getFarmID())));
	}
	
	protected function buildVirtualAPI(Application_Model_Farm $farm) {
		$farm->setNumberOfProducts(Application_Model_Query_FarmProduct::getInstance()->getProductCount($farm->getFarmID()));
		$farm->setNumberOfComments(Application_Model_Query_FarmComment::getInstance()->getCommentCount($farm->getFarmID()));
	}
	
	
}
?>