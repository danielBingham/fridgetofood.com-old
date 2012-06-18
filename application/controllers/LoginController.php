<?php

class LoginController extends Zend_Controller_Action
{
	private $_auth;
	private $_authAdapter;

    // {{{ init():                      public void
	
    public function init()
    {
    	$this->_authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $this->_authAdapter->setTableName('users')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('md5(?)');
    	
        $this->_auth = Zend_Auth::getInstance();
    }

    // }}}
   
    // {{{ seeUser(Application_Model_User $user):                           private void

    public function seeUser(Application_Model_User $user) {
        $user->setSeen(Zend_Date::now());

        $persistor = new Application_Model_Persistor_User();
        $persistor->save($user);
    }

    // }}}
 
    // {{{ indexAction():               public void

    public function indexAction()
    {
    	if(!$this->getRequest()->isPost()) {
        	return;
    	}
    
    	$this->_authAdapter->setIdentity($this->getRequest()->getPost('email'));
    	$this->_authAdapter->setCredential($this->getRequest()->getPost('password'));
    	$result = $this->_auth->authenticate($this->_authAdapter);
    	
		if (!$result->isValid()) {
            if(!isset($this->view->errors)) {
                $this->view->errors = array();
            }
			$this->view->errors['password'] = 'Login failed.  Your password or email is incorrect.';
			return;
		}
		
		$userRaw = $this->_authAdapter->getResultRowObject();
        $user = Application_Model_Query_User::getInstance()->get($userRaw->id);
		$this->_auth->getStorage()->write($user);
        $this->seeUser($user);
		
        $this->_helper->redirector('index', 'index');
    	
    	
    }

    // }}}
    // {{{ facebookAction():            public void
    
    public function facebookAction() {
    	$code = $this->getRequest()->getParam('code', null);
	
    	$authService= new Application_Service_OAuth2_Facebook();    	
        $authService->authenticate($code);
        
        $user = $authService->getUser();
        if($user === null) {
            $user = $authService->createUser();
        }
    	$this->_auth->getStorage()->write($user);
        $this->seeUser($user);	
    	$this->_helper->redirector('index', 'index');
    }

    // }}}
    // {{{ googleAction():              public void
    
    public function googleAction() {
        $code = $this->getRequest()->getParam('code', null);
        
        $authService = new Application_Service_OAuth2_Google();
        $authService->authenticate($code);
        
        $user = $authService->getUser();
        if($user == null) {
            $user = $authService->createUser();
        } 
        $this->_auth->getStorage()->write($user);
        $this->seeUser($user);
        $this->_helper->redirector('index', 'index');
    }

    // }}}
    // {{{ logoutAction():              public void
    
    public function logoutAction() {
    	if(Zend_Auth::getInstance()->hasIdentity()) {
    		Zend_Auth::getInstance()->clearIdentity();
    	}
    	$this->_helper->redirector('index', 'index');
    }

    // }}}
    // {{{ forgotAction():              public void

    public function forgotAction() {
        $this->view->error = null;
        if($this->getRequest()->isPost()) {
            $email = $this->getRequest()->getParam('email', null);
            if($email === null) {
                throw new RuntimeException('We have post, but no e-mail.  This should not happen.  Please report this as a bug.');
            }

            $user = Application_Model_Query_User::getInstance()->findOne(array('email'=>$email));
            if($user === null) {
                $this->view->state = 'NOTSENT';
                $this->view->error = 'NOUSER';
                return;
            }

            $passwordGenerator = new Application_Service_User_PasswordGenerator();
            $password = $passwordGenerator->generate();
            $user->setPassword($password);

            $persistor = new Application_Model_Persistor_User();
            $persistor->save($user); 

            $mail = new Zend_Mail();
            $text = <<< END
Here is the new password you requested for Fridge to Food: $password

You requested it for the email: $email

This is only a temporary password, please log in and change it as soon as possible.  You can change it by
editing your profile.  Log in and then click on your name in the top right corner.  This will take you
to your profile view.  Click 'Edit' on the top right of the profile header.  You will need to enter
your current password and then enter a new one and edit your profile.
END;
            $mail->setBodyText($text);
            $mail->setFrom('no-reply@fridgetofood.com');
            $mail->addTo($email);
            $mail->setSubject('Your Temporary Fridge to Food Password');
            $mail->send(); 

            $this->view->state = 'SENT';
            return;
        }
        $this->view->state = 'NOTSENT';

        
    }

    // }}}

}

