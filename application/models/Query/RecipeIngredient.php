<?php
class Application_Model_Query_RecipeIngredient extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_RecipeIngredient::$_instance)) {
			Application_Model_Query_RecipeIngredient::$_instance = new Application_Model_Query_RecipeIngredient();
		}
		return Application_Model_Query_RecipeIngredient::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_RecipeIngredient();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_RecipeIngredient();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_RecipeIngredient();
	}
}
?>