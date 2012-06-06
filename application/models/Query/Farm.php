<?php
class Application_Model_Query_Farm extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;
	
	public function getFarmForImage(Application_Model_Image $image) {
		$db = Zend_Db_Table::getDefaultAdapter();

		$id = $db->fetchOne('select farm_id from farm_images where image_id=?', $image->getImageID());
		return $this->get($id);
	}
	
	public function getFarmsForMarket(Application_Model_Market $market) {
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$farmIDs = $db->fetchAll('select farm_id from market_farms where market_id=?', $market->getMarketID());
		
		$farms = array();
		foreach($farmIDs as $id) {
			$farms[] = $this->get($id['farm_id']);
		}
		return $farms;
	}
	
	/****************************************************************************
	 * Standard Query API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Farm::$_instance)) {
			Application_Model_Query_Farm::$_instance = new Application_Model_Query_Farm();
		}
		return Application_Model_Query_Farm::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Farm();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Farm();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Farm();
	}
	
	
}
?>