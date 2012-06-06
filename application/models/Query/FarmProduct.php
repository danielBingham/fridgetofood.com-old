<?php
class Application_Model_Query_FarmProduct extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;
	
	
	public function getProductCount($farmID) {
		$db = Zend_Db_Table::getDefaultAdapter();

		return $db->fetchOne('select count(id) as number from farm_products where farm_id=?', $farmID);
	
	}
	
	/****************************************************************************
	 * Standard Query API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_FarmProduct::$_instance)) {
			Application_Model_Query_FarmProduct::$_instance = new Application_Model_Query_FarmProduct();
		}
		return Application_Model_Query_FarmProduct::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_FarmProduct();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_FarmProduct();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_FarmProduct();
	}
	
}
?>