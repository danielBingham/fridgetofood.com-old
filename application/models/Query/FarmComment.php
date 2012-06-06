<?php
class Application_Model_Query_FarmComment extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;
	
	
	public function getCommentCount($farmID) {
		$db = Zend_Db_Table::getDefaultAdapter();
		
		return $db->fetchOne('select coalesce(count(id), 0) from farm_comments where farm_id=?', $farmID);
	}
	
	/****************************************************************************
	 * Standard Query Methods
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_FarmComment::$_instance)) {
			Application_Model_Query_FarmComment::$_instance = new Application_Model_Query_FarmComment();
		}
		return Application_Model_Query_FarmComment::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_FarmComment();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_FarmComment();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_FarmComment();
	}
}
?>