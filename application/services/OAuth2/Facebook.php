<?php
/**
*
*/
class Application_Service_OAuth2_Facebook extends OAuth2_Facebook {
    private $data;
    private $persistor;

    // {{{ __construct()

    public function __construct() {
        $this->data = null;
        $this->persistor = new Application_Model_Persistor_User();
        $clientID = Zend_Registry::get('config')->oauth->facebook->clientID;
        $secret = Zend_Registry::get('config')->oauth->facebook->secret;
        parent::__construct($clientID, $secret);
    }

    // }}}

    // {{{ createUser($facebookInfo):                                       public Application_Model_User
	
	public function createUser() {
		$user = new Application_Model_User();
		$user->setEmail(null);
		$user->setDisplayName($this->data->name);
		
		$this->persistor->save($user);
        
        $this->associate($user);
        
        $bonusGiver = new Application_Service_User_GrantBonus();
        $bonusGiver->grantReputationBonus($user, 1, 'new user');

        $updater = new Application_Service_User_UpdateReputation();
        $updater->updateReputationForUser($user);

		return $user;
	}

    // }}}
    // {{{ authenticate($code):                                             public void
    
    public function authenticate($code) {
        $this->data = $this->getUserInformation($code);
    }

    // }}}
    // {{{ getUser():                                                       public Application_Model_User
 	
	public function getUser() {
		return Application_Model_Query_User::getInstance()->getUserForFacebook($this->data->email);
	}

    // }}}
    // {{{ associate(Application_Model_User $user):                         public void

    public function associate(Application_Model_User $user) {
        $this->persistor->associateFacebook($user, $this->data->email); 
    }

    // }}}	
	
}
?>
