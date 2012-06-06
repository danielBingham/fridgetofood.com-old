<?PHP

class Application_Service_Image_Vote {

    // {{{ voteUp(Application_Model_User $user, Application_Model_Image $image):                 public void
    
    public function voteUp(Application_Model_User $user, Application_Model_Image $image) {
        $mapper = new Application_Model_Mapper_Image();
        $mapper->vote($user, $image, 1);

        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($image->getUser());
  
        $ribbonHandler = new Application_Service_Ribbon_Handler();
        $ribbonHandler->checkAndGrant($user, 'voter');
        $ribbonHandler->checkAndGrant($user, 'resident');
        $ribbonHandler->checkAndGrant($user, 'electorate');
        $ribbonHandler->checkAndGrant($user, 'citizen');
    }

    // }}}
    // {{{ voteDown(Application_Model_User $user, Application_Model_Image $image):                public void

    public function voteDown(Application_Model_User $user, Application_Model_Image $image) {
        $mapper = new Application_Model_Mapper_Image();
        $mapper->vote($user, $image, -1);
    
        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($image->getUser());
        
        $ribbonHandler = new Application_Service_Ribbon_Handler();
        $ribbonHandler->checkAndGrant($user, 'critic');
        $ribbonHandler->checkAndGrant($user, 'resident');
        $ribbonHandler->checkAndGrant($user, 'electorate');
        $ribbonHandler->checkAndGrant($user, 'citizen');
    }

    // }}} 
    // {{{ getVote(Application_Model_User $user, Application_Model_Image $image):                 public void

    public function getVote(Application_Model_User $user, Application_Model_Image $image) {
        return Application_Model_Query_Image::getInstance()->getVoteForUser($user, $image);
    }

    // }}}


}

?>
