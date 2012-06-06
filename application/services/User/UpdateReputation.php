<?php
/**
*
*/
class Application_Service_User_UpdateReputation {

    // {{{ updateReputationForAllUsers():                                   public void
    public function updateReputationForAllUsers() {
        $users = Application_Model_Query_User::getInstance()->fetchAll();
        foreach($users as $user) {
            $this->calculateReputationForUser($user);
        }
    }

    // }}}
    // {{{ updateReputationForUser(Application_Model_User $user):        public void

    public function updateReputationForUser(Application_Model_User $user) {
        $db = Zend_Db_Table::getDefaultAdapter();
       
		$sql = 'update users left join (select sum(recipe_votes.vote)*10 as reputation, recipes.user_id as user_id from recipe_votes join recipes on (recipe_votes.recipe_id=recipes.id) where recipes.is_community=0 group by user_id ) as recipe_reputation on recipe_reputation.user_id = users.id left join (select sum(recipe_votes.vote)*2 as reputation, recipes.user_id as user_id from recipe_votes join recipes on (recipe_votes.recipe_id=recipes.id) where recipes.is_community=1 group by user_id) as community_reputation on community_reputation.user_id=users.id left join (select sum(image_votes.vote)*5 as reputation, images.user_id as user_id from images left join image_votes on (images.id=image_votes.image_id) group by user_id) as image_reputation on image_reputation.user_id = users.id left join (select sum(value) as reputation, user_id from reputation_bonuses group by user_id) as bonus_reputation on bonus_reputation.user_id=users.id set users.reputation = coalesce(recipe_reputation.reputation, 0)+coalesce(image_reputation.reputation, 0)+coalesce(bonus_reputation.reputation, 0)+coalesce(community_reputation.reputation, 0) where users.id=?';

        $db->query($db->quoteInto($sql, $user->getUserID(), 'INTEGER'));
        $reputation = $db->fetchOne('select reputation from users where id=?', $user->getUserID());
        $user->setReputation($reputation); 
    }

    // }}}

}
?>
