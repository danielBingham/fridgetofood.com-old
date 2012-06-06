<?php
class Application_Model_Query_Tag extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;
	
	
	
	public function getTagsForRecipe($recipeID) {
		$db = Zend_Db_Table::getDefaultAdapter();

		$results = $db->fetchAll('select tag_id from recipe_tags where recipe_id=?', $recipeID);
		
		$tags = array();
		foreach($results as $id) {
			$tags[] = $this->get($id['tag_id']);	
		}
		
		return $tags;
	}
	
	public function getTagsForFarm($farmID) {
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$results = $db->fetchAll('select tag_id from farm_tags where farm_id=?', $farmID);
		
		$tags = array();
		foreach($results as $id) {
			$tags[] = $this->get($id['tag_id']);
		}
		
		return $tags;
	}
	
	/****************************************************************************
	 * Standard Query API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Tag::$_instance)) {
			Application_Model_Query_Tag::$_instance = new Application_Model_Query_Tag();
		}
		return Application_Model_Query_Tag::$_instance;
	}
	
	/**
	 *
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Tag();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Tag();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Tag();
	}
	
	
}
?>