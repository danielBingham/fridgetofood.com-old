<?php
/**
*
*/
class Application_Service_User_GrantBonus {

    // {{{ grantReputationBonus(Application_Model_User $user, $bonus, $reason='NR'):                public void

    public function grantReputationBonus(Application_Model_User $user, $bonus, $reason='NR') {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array(
            'user_id'=>$user->getUserID(),
            'value'=>$bonus,
            'reason'=>$reason
        );

        $db->insert('reputation_bonuses', $data);
    }

    // }}}

}

?>
