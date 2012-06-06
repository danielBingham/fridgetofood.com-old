<?php
/**
*
*/
class Application_Service_Ribbon_Handler {

    // {{{ checkAndGrant(Application_Model_User $user, $ribbon):             public void

    public function checkAndGrant(Application_Model_User $user, $ribbon) {
        // We're gonna do this less than perfectly for now.  Until I get around to fixing the model
        // so that everything has a proper query and all that.  We're just gonna cheat and put the
        // SQL in the service.

        // FIXME Put the SQL in the model where it belongs.
        // TODO Optimize me.
        $db = Zend_Db_Table::getDefaultAdapter();
    
 
        // {{{ Voter -- Have they cast a vote?
        if($ribbon == 'voter' || $ribbon == 'all') { 
            $result = $db->fetchAll('SELECT id FROM recipe_votes WHERE ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($result) > 0 && !$this->hasRibbon($user, 'voter')) {
                $this->grantRibbon($user, 'voter');
            }         
            
            $result = $db->fetchAll('SELECT id FROM image_votes WHERE ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($result) > 0 && !$this->hasRibbon($user, 'voter')) {
                $this->grantRibbon($user, 'voter');
            }
        }
        // }}}
        // {{{ Critic -- Have they cast a down vote? 
        if($ribbon == 'critic' || $ribbon == 'all') {
            $result = $db->fetchAll('SELECT id FROM recipe_votes WHERE vote=-1 AND ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($result) >= 1 && !$this->hasRibbon($user, 'critic')) {
                $this->grantRibbon($user, 'critic');
            }         
            
            $result = $db->fetchAll('SELECT id FROM image_votes WHERE vote=-1 AND ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($result) >= 1 && !$this->hasRibbon($user, 'critic')) {
                $this->grantRibbon($user, 'critic');
            }
        }
        // }}}
        // {{{ Autobiographer -- Have they filled out their profile?
        if($ribbon == 'autobiographer' || $ribbon == 'all') {
            if($user->getAbout() &&
                $user->getDisplayName() &&
                $user->getWebsite() &&
                $user->getWebsiteURL() && !$this->hasRibbon($user, 'autobiographer')) {
                $this->grantRibbon($user, 'autobiographer');
            }
        }
        // }}}
        
        if($ribbon == 'resident' || $ribbon == 'electorate' || $ribbon == 'citizen' || $ribbon == 'all') {
            // These will be used for all of the next three ribbons. 
            $recipeVotes = $db->fetchAll('SELECT id FROM recipe_votes WHERE ' . $db->quoteInto('user_id=?', $user->getUserID()));
            $imageVotes = $db->fetchAll('SELECT id FROM image_votes WHERE ' . $db->quoteInto('user_id=?', $user->getUserID()));
        }
       
        // {{{ Resident -- Have they cast 30 recipe votes and 100 image votes?
        if($ribbon == 'resident' || $ribbon == 'all') {
            if(count($recipeVotes) >= 30 && count($imageVotes) >= 100 && !$this->hasRibbon($user, 'resident')) {
                $this->grantRibbon($user, 'resident');
            }
        }
        // }}}
        // {{{ Electorate -- Have they cast 300 recipe votes and 1000 image votes?
        if($ribbon == 'electorate' || $ribbon == 'all') {
            if(count($recipeVotes) >= 300 && count($imageVotes) >= 1000 && !$this->hasRibbon($user, 'electorate')) {
                $this->grantRibbon($user, 'electorate');
            }
        }
        // }}}
        // {{{ Citizen -- Have they cast 100 recipe votes and 300 image votes?
        if($ribbon == 'citizen' || $ribbon == 'all') {
            if(count($recipeVotes) >= 100 && count($imageVotes) >= 300 && !$this->hasRibbon($user, 'citizen')) {
                $this->grantRibbon($user, 'citizen');
            }
        }
        // }}}
        
        // {{{ Yum -- Have any of their recipes recieved an upvote?
        if($ribbon == 'yum' || $ribbon == 'all') {
            $recipesWithUpVotes = $db->fetchAll('SELECT DISTINCT recipes.id 
                                        FROM recipes 
                                            JOIN recipe_votes 
                                                ON (recipes.id = recipe_votes.recipe_id) 
                                        WHERE recipe_votes.vote=1 AND ' . $db->quoteInto('recipes.user_id=?', $user->getUserID())); 

            $yum = $db->fetchAll('SELECT ribbons.id 
                                        FROM ribbons 
                                            JOIN user_ribbons 
                                                ON (ribbons.id = user_ribbons.ribbon_id) 
                                        WHERE ribbons.name="yum" AND ' . $db->quoteInto('user_ribbons.user_id=?', $user->getUserID()));

            if(count($yum) < count($recipesWithUpVotes)) {
                for($i = 0; $i < (count($recipesWithUpVotes) - count($yum)); $i++) {
                    $this->grantRibbon($user, 'yum');
                }
            }
        }
        // }}}
        // {{{ Yuck -- Have any of their recipes recieved a downvote?
        if($ribbon == 'yuck' || $ribbon == 'all') {
            $recipesWithDownVotes = $db->fetchAll('SELECT DISTINCT recipes.id 
                                        FROM recipes 
                                            JOIN recipe_votes 
                                                ON (recipes.id = recipe_votes.recipe_id) 
                                        WHERE recipe_votes.vote=-1 AND ' . $db->quoteInto('recipes.user_id=?', $user->getUserID())); 

            $yuck = $db->fetchAll('SELECT ribbons.id 
                                        FROM ribbons 
                                            JOIN user_ribbons 
                                                ON (ribbons.id = user_ribbons.ribbon_id) 
                                        WHERE ribbons.name="yuck" AND ' . $db->quoteInto('user_ribbons.user_id=?', $user->getUserID()));

            if(count($yuck) < count($recipesWithDownVotes)) {
                for($i = 0; $i < (count($recipesWithDownVotes) - count($yuck)); $i++) {
                    $this->grantRibbon($user, 'yuck');
                }
            }
        }
        // }}}
        // {{{ Three Star Recipe -- Have any of their recipes recieved more than 10 upvotes?
        if($ribbon == 'threestars' || $ribbon == 'all') {
            // We can accomplish this by comparing the number of recipes with more than 10 upvotes
            // to the number of ribbons.  Why didn't I think of that earlier?
            $recipes = $db->fetchAll('SELECT recipes.id, SUM(recipe_votes.vote) as total
                                        FROM recipes JOIN recipe_votes ON (recipes.id = recipe_votes.recipe_id)
                                        WHERE ' . $db->quoteInto('recipes.user_id=?', $user->getUserID()) . '
                                        GROUP BY recipes.id
                                        HAVING total >= 10');
            $threeStars = $db->fetchAll('SELECT user_ribbons.id 
                                            FROM ribbons JOIN user_ribbons ON (ribbons.id = user_ribbons.ribbon_id)
                                            WHERE ribbons.name="threestars" AND ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($recipes) > count($threeStars)) {
                for($i=0; $i < (count($recipes) - count($threeStars)); $i++) {
                    $this->grantRibbon($user, 'threestars');
                }
            }
        }
        // }}}
        // {{{ Four Star Recipe -- Have any of their recipes recieved more than 25 upvotes?
        if($ribbon == 'fourstars' || $ribbon == 'all') {
            $recipes = $db->fetchAll('SELECT recipes.id, SUM(recipe_votes.vote) as total
                                        FROM recipes JOIN recipe_votes ON (recipes.id = recipe_votes.recipe_id)
                                        WHERE ' . $db->quoteInto('recipes.user_id=?', $user->getUserID()) . '
                                        GROUP BY recipes.id
                                        HAVING total >= 25');
            $threeStars = $db->fetchAll('SELECT user_ribbons.id 
                                            FROM ribbons JOIN user_ribbons ON (ribbons.id = user_ribbons.ribbon_id)
                                            WHERE ribbons.name="threestars" AND ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($recipes) > count($threeStars)) {
                for($i=0; $i < (count($recipes) - count($threeStars)); $i++) {
                    $this->grantRibbon($user, 'fourstars');
                }
            }
        }
        // }}}
        // {{{ Five Star Recipe -- Have any of their recipes recieved more than 100 upvotes?
        if($ribbon == 'fivestars' || $ribbon == 'all') {
            $recipes = $db->fetchAll('SELECT recipes.id, SUM(recipe_votes.vote) as total
                                        FROM recipes JOIN recipe_votes ON (recipes.id = recipe_votes.recipe_id)
                                        WHERE ' . $db->quoteInto('recipes.user_id=?', $user->getUserID()) . '
                                        GROUP BY recipes.id
                                        HAVING total >= 100');
            $threeStars = $db->fetchAll('SELECT user_ribbons.id 
                                            FROM ribbons JOIN user_ribbons ON (ribbons.id = user_ribbons.ribbon_id)
                                            WHERE ribbons.name="threestars" AND ' . $db->quoteInto('user_id=?', $user->getUserID()));

            if(count($recipes) > count($threeStars)) {
                for($i=0; $i < (count($recipes) - count($threeStars)); $i++) {
                    $this->grantRibbon($user, 'fivestars');
                }
            }
        }
        // }}}
 
        // {{{ Cook -- Have they posted a recipe?
        if($ribbon == 'cook' || $ribbon == 'all') { 
            if(!$this->hasRibbon($user, 'cook') && $user->getRecipeCount() >= 1) {
                $this->grantRibbon($user, 'cook');
            } 
        }
        // }}}
        // {{{ Chef de Partie -- Have they posted more than 25 recipes?
        if($ribbon == 'chefdepartie' || $ribbon == 'all') {
            if(!$this->hasRibbon($user,'chefdepartie') && $user->getRecipeCount() >= 25) {
                $this->grantRibbon($user,'chefdepartie');
            }
        }
        // }}}
        // {{{ Sous Chef -- Have they posted more than 100 recipes?
        if($ribbon == 'souschef' || $ribbon == 'all') {
            if(!$this->hasRibbon($user,'souschef') && $user->getRecipeCount() >= 100) {
                $this->grantRibbon($user,'souschef');
            }
        }
        // }}}
        // {{{ Chef De Cuisine -- Have they posted more than 400 recipes?
        if($ribbon == 'chefdecuisine' || $ribbon == 'all') { 
            if(!$this->hasRibbon($user,'chefdecuisine') && $user->getRecipeCount() >= 400) {
                $this->grantRibbon($user,'chefdecuisine');
            }
        }
        // }}}

        if(Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->getStorage()->write(Application_Model_Query_User::getInstance()->get(Zend_Auth::getInstance()->getIdentity()->getUserID()));
        }
 
    }

    // }}}    

    // {{{ hasRibbon(Application_Model_User $user, $name):                  protected boolean
    
    protected function hasRibbon(Application_Model_User $user, $name) {
       $ribbon = Application_Model_Query_Ribbon::getInstance()->findOne(array('name'=>$name));
        return Application_Model_Query_Ribbon::getInstance()->doesUserHaveRibbon($user, $ribbon); 
    }

    // }}}
    // {{{ grantRibbon(Application_Model_user $user, $name):                protected void

    protected function grantRibbon(Application_Model_User $user, $name) {
        $ribbon = Application_Model_Query_Ribbon::getInstance()->findOne(array('name'=>$name));
        
        if(empty($ribbon)) {
            throw new RuntimeException('That ribbon does not exist!');
        }

        $mapper = new Application_Model_Mapper_Ribbon();
        $mapper->grantRibbonToUser($ribbon, $user); 
    }
    
    // }}}

}

?>
