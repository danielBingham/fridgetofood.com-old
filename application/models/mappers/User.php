<?php
class Application_Model_Mapper_User extends Application_Model_Mapper_Base {
    // {{{ updateVirtualAPI(Application_Model_User $user):                  public void
	
	public function updateVirtualAPI(Application_Model_User $user) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchAll('select count(id) as recipe_count from recipes where user_id=?', $user->getUserID());

		if(!empty($results)) {
			$user->setRecipeCount($results[0]['recipe_count']);
		} else {
			$user->setRecipeCount(0);
		}
	}

    // }}}
    // {{{ mergeAssociations(Application_Model_User $into, Application_Model_User $from):             public void
    
    public function mergeAssociations(Application_Model_User $into, Application_Model_User $from) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array ('user_id'=>$into->getUserID());
 
        $db->update('user_facebooks', $data, $db->quoteInto('user_id=?', $from->getUserID()));
        $db->update('user_googles', $data, $db->quoteInto('user_id=?', $from->getUserID()));
    }

    // }}}	
    // {{{ mergeReputation(Application_Model_User $into, Application_Model_User $from):             public void
    
    public function mergeReputation(Application_Model_User $into, Application_Model_User $from) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array ('user_id'=>$into->getUserID());
 
        $db->update('reputation_bonuses', $data, $db->quoteInto('user_id=?', $from->getUserID()));
    }

    // }}}	
    
    // Standard mapper API
    // {{{ getDbTable():                                                    public Application_Model_DbTable_User
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_User();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ fromDbObject(Application_Model_User $user, $data):               public void 

	public function fromDbObject(Application_Model_User $user, $data) {
		$this->fromDbArray($user, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_User $user, array $data):          public void
	
	public function fromDbArray(Application_Model_User $user, array $data) {
        parent::fromDbArray($user, $data);
        $user->created = new Zend_Date($user->created, Zend_Date::ISO_8601);
        $user->seen = new Zend_Date($user->seen, Zend_Date::ISO_8601);
        $user->notified = new Zend_Date($user->notified, Zend_Date::ISO_8601);
        $user->modified = new Zend_Date($user->modified, Zend_Date::ISO_8601);
        $user->import_blog = ($user->import_blog == 1 ? true : false);
        $user->password = ($user->password == null ? 'NOTSET' : 'SET');
	}

    // }}}	
    // {{{ toDbArray(Application_Model_User $user):                         public array
	
	public function toDbArray(Application_Model_User $user) {
        $data = parent::toDbArray($user);
        if($data['password'] == 'SET' || $data['password'] == 'NOTSET') {
            unset($data['password']);
        }
        $data['created'] = $data['created']->toString('YYYY-MM-dd HH:mm:ss');
        return $data;	
    }

    // }}}

}
?>
