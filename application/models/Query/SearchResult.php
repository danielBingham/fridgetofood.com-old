<?php

class Application_Model_Query_SearchResult extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

	/****************************************************************************
	 * Standard Query API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_SearchResult::$_instance)) {
			Application_Model_Query_SearchResult::$_instance = new Application_Model_Query_SearchResult();
		}
		return Application_Model_Query_SearchResult::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_SearchResult();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_SearchResult();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_SearchResult();
	}
	
}

?>
