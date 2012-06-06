<?PHP

class AdminController extends Zend_Controller_Action {


    // {{{ indexAction()

    public function indexAction() {
        if(!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getUserID() != 2) {
            throw new RuntimeException('You are not the admin.');
        }

    }

    // }}}
    // {{{ updateRibbonsAction()

    public function updateRibbonsAction() {
        if(!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getUserID() != 2) {
            throw new RuntimeException('You are not the admin.');
        }

        $ribbonHandler = new Application_Service_Ribbon_Handler();
        
        $users = Application_Model_Query_User::getInstance()->fetchAll();
        foreach($users as $user) {
            $ribbonHandler->checkAndGrant($user, 'all');
        }

        return $this->_helper->redirector('index');

    }

    // }}}

}

?>
