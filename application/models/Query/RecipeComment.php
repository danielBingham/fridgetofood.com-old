<?php
/**
*
*/
class Application_Model_Query_RecipeComment extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

    // Standard Query API
    // {{{ getInstance():                                                   public static Application_Model_Query_RecipeComment
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_RecipeComment::$_instance)) {
			Application_Model_Query_RecipeComment::$_instance = new Application_Model_Query_RecipeComment();
		}
		return Application_Model_Query_RecipeComment::$_instance;
	}

    // }}}
    // {{{ getMapper():                                                     public Application_Model_Mapper_RecipeComment
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_RecipeComment();
		}
		return $this->_mapper;
	}

    // }}}
    // {{{ getBuilder():                                                    public Application_Model_Builder_RecipeComment
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_RecipeComment();
		}
		return $this->_builder;
	}

    // }}}
    // {{{ getModel():                                                      Application_Model_RecipeComment
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_RecipeComment();
	}
    
    // }}}

}
?>
