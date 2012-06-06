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
        $user->setPassword(null);
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

}

