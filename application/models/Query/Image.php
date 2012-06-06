<?php
/**
*
*/
class Application_Model_Query_Image extends Application_Model_Query_Abstract {
	private static $_instance;
	private $_mapper;
	private $_builder;

    // {{{ getTotal():                                                      public int
	
	public function getTotal() {
		$db = Zend_Db_Table::getDefaultAdapter();
		$total = $db->fetchOne('select count(id) from images where id in (select image_id as id from recipe_images)');
		return $total;
	}

    // }}}
    // {{{ getImagesForRecipe($recipeID):                                   public array(Application_Model_Image)
	
	public function getImagesForRecipe($recipeID) {
		$db = Zend_Db_Table::getDefaultAdapter();

		$results = $db->fetchAll('select image_id, (select coalesce(sum(image_votes.vote), 0) from image_votes where image_id=recipe_images.image_id) as votes from recipe_images where recipe_id=? order by votes desc', $recipeID);
		
		$images = array();
		foreach($results as $id) {
			$images[] = $this->get($id['image_id']);	
		}
		
		return $images;
	}

    // }}}
    // {{{ getImagesForFarm($farmID):                                       public array(Application_Model_Image)
	
	public function getImagesForFarm($farmID) {
		$db = Zend_Db_Table::getDefaultAdapter();

		$results = $db->fetchAll('select image_id, (select coalesce(sum(image_votes.vote), 0) from image_votes where image_id=farm_images.image_id) as votes from farm_images where farm_id=? order by votes desc', $farmID);
		
		$images = array();
		foreach($results as $id) {
			$images[] = $this->get($id['image_id']);
		}
		
		return $images;
	}

    // }}}
    // {{{ getImagesForIngredient(Application_Model_Ingredient $ingredient):                        public array(Application_Model_Image)
	
	public function getImagesForIngredient(Application_Model_Ingredient $ingredient) {
		$db = Zend_Db_Table::getDefaultAdapter();

		$results = $db->fetchAll('select image_id, (select coalesce(sum(image_votes.vote), 0) from image_votes where image_id=ingredient_images.image_id) as votes from ingredient_images where ingredient_id=? order by votes desc', $ingredient->getIngredientID());
		
		$images = array();
		foreach($results as $id) {
			$images[] = $this->get($id['image_id']);
		}
		
		return $images;
	}

    // }}}	
    // {{{ getVoteForUser(Application_Model_User $user):                    public int

    public function getVoteForUser(Application_Model_User $user, Application_Model_Image $image) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $sql = 'SELECT vote 
                        FROM image_votes 
                        WHERE ' . $db->quoteInto('user_id=?', $user->getUserID()) . '
                        AND ' . $db->quoteInto('image_id=?', $image->getImageID());

        $vote = $db->fetchOne($sql);
        return $vote;
    }

    // }}}

	// Standard Query API
    // {{{ getInstance():                                                   public static Application_Model_Query_Image
	
	/**
	 * 
	 */
	public static function getInstance() {
		if(empty(Application_Model_Query_Image::$_instance)) {
			Application_Model_Query_Image::$_instance = new Application_Model_Query_Image();
		}
		return Application_Model_Query_Image::$_instance;
	}

    // }}}
    // {{{ getMapper():                                                     protected Application_Model_Mapper_Image
	
	/**
	 *
	 */
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Image();
		}
		return $this->_mapper;
	}

    // }}}
    // {{{ getBuilder():                                                    public Application_Model_Builder_Image
	
	/**
	 * 
	 */
	public function getBuilder() {
		if(empty($this->_builder)) {
			$this->_builder = new Application_Model_Builder_Image();
		}
		return $this->_builder;
	}

    // }}}
    // {{{ getModel():                                                      public Application_Model_Image
	
	/**
	 * 
	 */
	public function getModel() {
		return new Application_Model_Image();
	}

    // }}}	
	
}
?>
