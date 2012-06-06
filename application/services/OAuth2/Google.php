<?php
/**
*
*/
class Application_Service_OAuth2_Google extends OAuth2_Google {
    private $data;
    private $persistor;


    // {{{ __construct()

    public function __construct() {
        $this->data = null;
        $this->persistor = new Application_Model_Persistor_User();
        $clientID = Zend_Registry::get('config')->oauth->google->clientID;
        $secret = Zend_Registry::get('config')->oauth->google->secret;
        parent::__construct($clientID, $secret);
    }

    // }}}

    // {{{ createUser():                                         public Application_Model_User
	
	public function createUser() {
    	$user = new Application_Model_User();
		$user->setEmail(null);
		$user->setDisplayName($this->data->name);
		
		$this->persistor->save($user);

        $this->associate($user); 

        $bonusGiver = new Application_Service_User_GrantBonus();
        $bonusGiver->grantReputationBonus($user, 1, 'new user');

        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($user);
        
		return $user;
	}

    // }}}
    // {{{ authenticate($code):                                             public void
    
    public function authenticate($code) {
        $this->data = $this->getUserInformation($code);
    }

    // }}}
    // {{{ getUser($code):                                                  public Application_Model_User
 	
	public function getUser() {
		return Application_Model_Query_User::getInstance()->getUserForGoogle($this->data->email);
	}

    // }}}	
    // {{{ associate(Application_Model_User $user):                         public void

    public function associate(Application_Model_User $user) {
        $this->persistor->associateGoogle($user, $this->data->email);
    }

    // }}}

}
?>
