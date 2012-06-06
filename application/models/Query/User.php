<?php
class Application_Model_Query_User extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

    // {{{ getUserForFacebook($email):                                      public Application_Model_User

    public function getUserForFacebook($email) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $results = $db->fetchAll('SELECT user_id FROM user_facebooks WHERE email=?', array($email));

        if(count($results) == 0) {
            return null;
        }
        
        return Application_Model_Query_User::getInstance()->get($results[0]['user_id']);
    }

    // }}}
    // {{{ getUserForGoogle($email):                                      public Application_Model_User

    public function getUserForGoogle($email) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = 'SELECT user_id FROM user_googles WHERE ' . $db->quoteInto('email=?', $email); 
        $results = $db->fetchAll($sql);
 
        if(count($results) == 0) {
            return null;
        }
        
        return Application_Model_Query_User::getInstance()->get($results[0]['user_id']);
    }

    // }}}
    
    // Standard Query API
     // {{{ getInstance():                                                  public static Application_Model_Query_User
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_User::$_instance)) {
			Application_Model_Query_User::$_instance = new Application_Model_Query_User();
		}
		return Application_Model_Query_User::$_instance;
	}

    // }}}
    // {{{ getMapper():                                                     protected Application_Model_Mapper_User
	
	/**
	 *
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_User();
		}
		return $this->_mapper;
	}

    // }}}
    // {{{ getBuilder():                                                    public Application_Model_Builder_User
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_User();
		}
		return $this->_builder;
	}

    // }}}
    // {{{ getModel():                                                      public Application_Model_User
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_User();
	}

    // }}}	
	
}

?>
