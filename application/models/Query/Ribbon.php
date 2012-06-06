<?php
class Application_Model_Query_Ribbon extends Application_Model_Query_Abstract {
	private $_mapper;
	private $_builder;
	private static $_instance;

    // {{{ getRibbonsForUser(Application_Model_User $user):                 public array
	
	public function getRibbonsForUser(Application_Model_User $user) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchAll('select ribbon_id from user_ribbons where user_id=?', $user->getUserID());
		
		$ribbons = array();
		foreach($results as $result) {
			$ribbons[] = $this->get($result['ribbon_id']);
		}
		return $ribbons;
	}

    // }}}
    // {{{ doesUserHaveRibbon(Application_Model_User $user, Application_Model_Ribbon $ribbon):      public boolean

    public function doesUserHaveRibbon(Application_Model_User $user, Application_Model_Ribbon $ribbon) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $result = $db->fetchAll('select id from user_ribbons where user_id=? and ribbon_id=?', array($user->getUserID(), $ribbon->getRibbonID()));
        if(count($result) == 0) {
            return false;
        } else {
            return true;
        }
    }

    // }}}
    // {{{ getNumberEarned(Application_Model_Ribbon $ribbon):               public int
	
	public function getNumberEarned(Application_Model_Ribbon $ribbon) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$total = $db->fetchOne('select count(ribbon_id) from user_ribbons where ribbon_id =?', $ribbon->getRibbonID());
		return $total;
	}

    // }}}
	
	/****************************************************************************
	 * Standard Ribbon API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Ribbon::$_instance)) {
			Application_Model_Query_Ribbon::$_instance = new Application_Model_Query_Ribbon();
		}
		return Application_Model_Query_Ribbon::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Ribbon();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Ribbon();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Ribbon();
	}
	
}

?>
