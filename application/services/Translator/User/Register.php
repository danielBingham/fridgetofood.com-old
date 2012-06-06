<?PHP

class Application_Service_Translator_User_Register {
    private $_errors = array();

    // {{{ translate(Application_Model_User $user, array $post):            public void

    public function translate(Application_Model_User &$user, array $post) {
        $success = true;
        if($post['confirm'] != $post['password']) {
            $this->_errors[] = 'Passwords must match.';
            $success = false;
        }

        if(strtolower($post['humanity']) != 'obama') {
            $this->_errors[] = 'Your bot challenge answer is incorrect.  Either you are a bot, or you typed it wrong.  Try again, remember, only his last name.';
            $success = false;
        }

        $user = Application_Model_Query_User::getInstance()->findOne(array('email'=>$post['email']));

        if(count($user) !== 0) {
            $this->_errors[] = 'Someone is already registered with that e-mail address.  Please log in to your existing account, rather than creating a new one.';
            $success = false;
        }


        if($success === false) {
            return false;
        }

        $user = new Application_Model_User();
        $user->setEmail($post['email']);
        $user->setPassword($post['password']);
        $user->setDisplayName($post['display_name']);

        $user->setSeen(Zend_Date::now());

        $persistor = new Application_Model_Persistor_User();
        $persistor->save($user);

        $bonusGiver = new Application_Service_User_GrantBonus();
        $bonusGiver->grantReputationBonus($user, 1, 'new user');

        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($user);

        return true;
    }

    // }}}
    
    // {{{ getErrors():                                                     public array

    public function getErrors() {
        return $this->_errors;
    }

    // }}}
}

?>
