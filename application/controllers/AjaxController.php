<?PHP

class AjaxController extends Zend_Controller_Action {


    public function badgeAction() {
        $userID = $this->getRequest()->getParam('id', null);
        if($userID === null) {
            throw new RuntimeException('We can\'t load the badge for a user with out an id.');
        }
        
        $this->view->user = Application_Model_Query_User::getInstance()->get($userID);
        $this->_helper->layout->disableLayout();
    }

}

?>
