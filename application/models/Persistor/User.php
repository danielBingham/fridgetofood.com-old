<?php
class Application_Model_Persistor_User {

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
    // {{{ associateGoogle(Application_Model_User $user, $email):         public void

    public function associateGoogle(Application_Model_User $user, $email) {
        $db = Zend_Db_Table::getDefaultAdapter();
       
        $data = array(
            'user_id'=>$user->getUserID(),
            'email'=>$email
        );
         
        $db->insert('user_googles', $data);

    }

    // }}}
    
    
    // {{{ public void save(Application_Model_User $user)
    	
	public function save(Application_Model_User $user) {
		if($user->id) {
            $user->modified = Zend_Date::now();
		} else {
            $user->created = Zend_Date::now();
            $user->modified = Zend_Date::now();
		}
        parent::save($user);
        
        if(Zend_Auth::getInstance()->hasIdentity() && Zend_Auth::getInstance()->getIdentity()->id == $user->id) {
           Zend_Auth::getInstance()->getStorage()->write($user); 
        }
	}

    // }}}

}
?>
