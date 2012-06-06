<?php
class Application_Service_Translator_User_Edit {
	private $_authAdapter;
    private $errors = array();
	
	private function getAuthAdapter() {
		if(empty($this->_authAdapter)) {
    		$this->_authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        	$this->_authAdapter->setTableName('users')
            	->setIdentityColumn('email')
            	->setCredentialColumn('password')
            	->setCredentialTreatment('md5(?)');
		}
		return $this->_authAdapter;
	}
	
	public function translate($post, Application_Model_User $user) {
	    $data = $post['user'];	
		if((!empty($data['email']) && $data['email'] != $user->getEmail() && $user->getEmail()) 
        || (!empty($data['newPassword']) && $user->getPassword())) {
			if($user->getPassword() && empty($data['password']) && !empty($data['newPassword'])) {
				$this->errors['password'] = 'You must enter your current password in order to change it.';
				return false;
			} else if ($user->getEmail() && !empty($data['email']) && empty($data['password'])) {
                $this->errors['email'] = 'You must enter your current password in order to change your email.';
                return false;
            }
			
			$this->getAuthAdapter()->setIdentity($user->getEmail());
	    	$this->getAuthAdapter()->setCredential($data['password']);
	    	$result = Zend_Auth::getInstance()->authenticate($this->_authAdapter);
	    	
	    	Zend_Auth::getInstance()->getStorage()->write($user);
	    	
			if (!$result->isValid()) {
				$this->errors['password'] = 'The password you entered is incorrect.';
				return false;
			} 
		}
		
        if(!empty($data['newPassword'])) {
			if($data['newPassword'] != $data['confirmNewPassword']) {
				$this->errors['confirmNewPassword'] = 'Your new passwords must match!';
				return false;
			} else {
                $user->setPassword($data['newPassword']);	
	        }	
		}
		
		foreach($data as $key=>$value) {
			if($key == 'confirmNewPassword' || $key == 'password' || $key == 'newPassword') {
				continue;
			} 
			
			$user->{$key} = $value;
		}
	
		return true;
		
	}

    public function getErrors() {
        return $this->errors;
    }
	
	
}
?>
