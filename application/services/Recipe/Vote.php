<?php
/**
*
*/
class Application_Service_Recipe_Vote {

    // {{{ voteUp(Application_Model_User $user, Application_Model_Recipe $recipe):                 public void
    
    public function voteUp(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $mapper = new Application_Model_Mapper_Recipe();
        $mapper->voteUp($user, $recipe);

        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($recipe->getUser());

        $ribbonHandler = new Application_Service_Ribbon_Handler();
        $ribbonHandler->checkAndGrant($recipe->getUser(), 'yum');
        $ribbonHandler->checkAndGrant($recipe->getUser(), 'threestars');
        $ribbonHandler->checkAndGrant($recipe->getUser(), 'fourstars');
        $ribbonHandler->checkAndGrant($recipe->getUser(), 'fivestars');
       
        $ribbonHandler->checkAndGrant($user, 'voter'); 
        $ribbonHandler->checkAndGrant($user, 'resident');
        $ribbonHandler->checkAndGrant($user, 'citizen');
        $ribbonHandler->checkAndGrant($user, 'electorate');
    }

    // }}}
    // {{{ voteDown(Application_Model_User $user, Application_Model_Recipe $recipe):                public void

    public function voteDown(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $mapper = new Application_Model_Mapper_Recipe();
        $mapper->voteDown($user, $recipe);
    
        $reputationUpdater = new Application_Service_User_UpdateReputation();
        $reputationUpdater->updateReputationForUser($recipe->getUser());
        
 
        $ribbonHandler = new Application_Service_Ribbon_Handler();
        $ribbonHandler->checkAndGrant($recipe->getUser(), 'yuck');

        $ribbonHandler->checkAndGrant($user, 'critic');
        $ribbonHandler->checkAndGrant($user, 'resident');
        $ribbonHandler->checkAndGrant($user, 'citizen');
        $ribbonHandler->checkAndGrant($user, 'electorate');

    }

    // }}} 
    // {{{ getVote(Application_Model_User $user, Application_Model_Recipe $recipe):                 public void

    public function getVote(Application_Model_User $user, Application_Model_Recipe $recipe) {
        return Application_Model_Query_Recipe::getInstance()->getVoteForUser($user, $recipe);
    }

    // }}}

}
?>
