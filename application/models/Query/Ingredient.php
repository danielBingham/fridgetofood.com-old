<?php
class Application_Model_Query_Ingredient extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

    // {{{ public int getTotal()
	
	public function getTotal() {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchOne('select count(id) as total from ingredients');
		return $results['total'];
	}

    // }}}
		
    // Standard Ingredient API
    // {{{ public static Application_Model_Query_Ingredient getInstance()
    	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Ingredient::$_instance)) {
			Application_Model_Query_Ingredient::$_instance = new Application_Model_Query_Ingredient();
		}
		return Application_Model_Query_Ingredient::$_instance;
	}

    // }}}
    // {{{ protected Application_Model_Mapper_Ingredient getMapper()
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Ingredient();
		}
		return $this->_mapper;
	}

    // }}}
    // {{{ public Application_Model_Builder_Ingredient getBuilder()
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Ingredient();
		}
		return $this->_builder;
	}

    // }}}
    // {{{ public Application_Model_Ingredient getModel()
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Ingredient();
	}

    // }}}	
}

?>
