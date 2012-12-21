<?php
class Application_Model_Query_Recipe extends Application_Model_Query_Abstract {
    protected $_model='Recipe';
	private static $_instance;

    // {{{ getTotal():                                                                              public int
	
	/**
	 * 
	 */
	public function getTotal() {
		$db = Zend_Db_Table::getDefaultAdapter();
		
		$results = $db->fetchAll('select count(id) as total from recipes');		
		return $results[0]['total'];
	}

    // }}}
    // {{{ getRecipeForImage(Application_Model_Image $image):                                       public Application_Model_Recipe
	
	public function getRecipeForImage(Application_Model_Image $image) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$recipeID = $db->fetchOne('select recipe_id from recipe_images where image_id=?', $image->getImageID());
		return $this->get($recipeID);	
	}

    // }}}	
    // {{{ getRecipeForTag(Application_Model_Tag $tag):                                             public array(Application_Model_Recipe)

	public function getRecipesForTag(Application_Model_Tag $tag) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$recipeIDs = $db->fetchAll('select recipe_id from recipe_tags where tag_id=?', $tag->getTagID());

		$recipes = array();
		foreach($recipeIDs as $recipeID) {
			$recipe = $this->get($recipeID['recipe_id']);
			$recipes[] = $recipe;
		}
		return $recipes;
	}

    // }}}
    // {{{ getVoteForUser(Application_Model_User $user, Application_Model_Recipe $recipe):          public int(1, -1, or null) 

    public function getVoteForUser(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $vote = $db->fetchOne('SELECT vote FROM recipe_votes WHERE recipe_id=? AND user_id=? LIMIT 1', 
                        array($recipe->getRecipeID(), $user->getUserID())); 
        if(empty($vote)) {
            return null;
        } else {
            return $vote;
        } 
    }

    // }}}

    // Virtual Field Determiners
    // {{{ determineVoteTotal(Application_Model_Recipe $recipe)

    public function determineVoteTotal(Application_Model_Recipe $recipe) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$result = $db->fetchAll('select COALESCE(SUM(COALESCE(recipe_votes.vote, 0)), 0) as voteTotal from recipe_votes where recipe_votes.recipe_id=?', $recipe->getRecipeID());

		if(count($result) != 0) {
			$recipe->voteTotal = $result[0]['voteTotal'];
		} else {
			$recipe->voteTotal = 0;
		}
    }

    // }}}
    // {{{ determineNumberOfComments(Application_Model_Recipe $recipe)

    public function determineNumberOfComments(Application_Model_Recipe $recipe) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$result = $db->fetchAll('select count(recipe_comments.id) as numberOfComments from recipe_comments where recipe_id=?', $recipe->getRecipeID());

		if(count($result) != 0) {
			$recipe->numberOfComments = $result[0]['numberOfComments'];
		} else {
			$recipe->numberOfComments = 0;
		}
    }

    // }}}
	
}

?>
