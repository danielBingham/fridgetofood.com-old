<?php
class Application_Model_Persistor_User {
	
	private $_mapper;

    // {{{ associateFacebook(Application_Model_User $user, $email):         public void

    public function associateFacebook(Application_Model_User $user, $email) {
        $db = Zend_Db_Table::getDefaultAdapter();
       
        $data = array(
            'user_id'=>$user->getUserID(),
            'email'=>$email
        );
         
        $db->insert('user_facebooks', $data);

    }

    // }}}
    // {{{ associateFacebook(Application_Model_User $user, $email):         public void

    public function associateGoogle(Application_Model_User $user, $email) {
        $db = Zend_Db_Table::getDefaultAdapter();
       
        $data = array(
            'user_id'=>$user->getUserID(),
            'email'=>$email
        );
         
        $db->insert('user_googles', $data);

    }

    // }}}
    
    // Standard Persistor API
    // {{{ protected Application_Model_Mapper_User getMapper()
	
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_User();
		}
		return $this->_mapper;
		
	}

    // }}}
    
    // {{{ public void save(Application_Model_User $user)
    	
	public function save(Application_Model_User $user) {
		if($user->getUserID()) {
			$this->update($user);
		} else {
			$this->insert($user);
		}
        
        if(Zend_Auth::getInstance()->hasIdentity() && Zend_Auth::getInstance()->getIdentity()->getUserID() == $user->getUserID()) {
           Zend_Auth::getInstance()->getStorage()->write($user); 
        }
	}

    // }}}

    // {{{ protected void insert(Application_Model_User $user)	
	
	protected function insert(Application_Model_User $user) {
		$user->setCreated(Zend_Date::now());
		$user->setModified(Zend_Date::now());
	
		$data = $this->getMapper()->toDbArray($user);
		$user->setUserID($this->getMapper()->getDbTable()->insert($data));
		
		if($user->getPassword()  && $user->getPassword() !== null) {
			$this->getMapper()->setPassword($user, $user->getPassword());	
		}
	}
    
    // }}}
    // {{{ protected void update(Application_Model_User $user)
	
	protected function update(Application_Model_User $user) {
		$user->setModified(Zend_Date::now());
		
		$data = $this->getMapper()->toDbArray($user);
		$this->getMapper()->getDbTable()->update($data, array('id=?'=>$user->getUserID()));
		
		if($user->getPassword() && $user->getPassword() !== null) {
			$this->getMapper()->setPassword($user, $user->getPassword());	
		}
	}
    
    // }}}
}
?>
