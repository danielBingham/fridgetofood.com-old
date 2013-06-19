<?php
class Application_Model_Query_Recipe extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

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
	
	/****************************************************************************
	 * Standard Query API
	 ****************************************************************************/
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Recipe::$_instance)) {
			Application_Model_Query_Recipe::$_instance = new Application_Model_Query_Recipe();
		}
		return Application_Model_Query_Recipe::$_instance;
	}
	
	/**
	 * 
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Recipe();
		}
		return $this->_mapper;
	}
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Recipe();
		}
		return $this->_builder;
	}
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Recipe();
	}
	
}

?>
