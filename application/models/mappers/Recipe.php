<?php
class Application_Model_Mapper_Recipe {
	private $_dbTable;

    // {{{ updateVirtualAPI(Application_Model_Recipe $recipe):                                      public void
	
	public function updateVirtualAPI(Application_Model_Recipe $recipe) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$result = $db->fetchAll('select COALESCE(SUM(COALESCE(recipe_votes.vote, 0)), 0) as voteTotal from recipe_votes where recipe_votes.recipe_id=?', $recipe->getRecipeID());
		if(count($result) != 0) {
			$recipe->setVoteTotal($result[0]['voteTotal']);
		} else {
			$recipe->setVoteTotal(0);
		}
		
		$result = $db->fetchAll('select count(recipe_comments.id) as numberOfComments from recipe_comments where recipe_id=?', $recipe->getRecipeID());
		if(count($result) != 0) {
			$recipe->setNumberOfComments($result[0]['numberOfComments']);
		} else {
			$recipe->setNumberOfComments(0);
		}
	}

    // }}}
    // {{{ tagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag):                 public void
    
    public function tagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $tagged = $db->fetchAll('
            SELECT *
                FROM recipe_tags
                WHERE ' . $db->quoteInto('recipe_id=?', $recipe->getRecipeID()) . '
                AND ' . $db->quoteInto('tag_id=?', $tag->getTagID()));

        if(count($tagged) == 0) {
            $db->query('INSERT INTO recipe_tags (recipe_id, tag_id) VALUES (?, ?)', array($recipe->getRecipeID(), $tag->getTagID()));
        }
    }

    // }}}
    // {{{ untagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag):               public void
    
    public function untagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('DELETE FROM recipe_tags WHERE recipe_id = ? AND tag_id = ?', array($recipe->getRecipeID(), $tag->getTagID()));
    }
    
    // }}}
    // {{{ incrementViews(Application_Model_Recipe $recipe):                                        public void

    public function incrementViews(Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('update recipes set views=views+1 where id=?', array($recipe->getRecipeID()));    
    }

    // }}}
    // {{{ voteUp(Application_Model_User $user, Application_Model_Recipe $recipe):                  public void	

    public function voteUp(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array(
                'recipe_id'=>$recipe->getRecipeID(),
                'user_id'=>$user->getUserID(),
                'vote'=>1,
                'created'=>new Zend_Db_Expr('NOW()'),
                'modified'=>new Zend_Db_Expr('NOW()')
        );
        
        $db->insert('recipe_votes', $data); 
    }

    // }}}
    // {{{ voteDown(Application_Model_User $user, Application_Model_Recipe $recipe):                public void
        
    public function voteDown(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array(
                'recipe_id'=>$recipe->getRecipeID(),
                'user_id'=>$user->getUserID(),
                'vote'=>-1,
                'created'=>new Zend_Db_Expr('NOW()'),
                'modified'=>new Zend_Db_Expr('NOW()')
        );
   
     
        $db->insert('recipe_votes', $data); 
    }

    // }}}
    // {{{ attachImage(Application_Model_Recipe $recipe, Applicaiton_Model_Image $image):           public void

    public function attachImage(Application_Model_Recipe $recipe, Application_Model_Image $image) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $attached = $db->fetchAll('
            SELECT * 
                FROM recipe_images
                WHERE ' . $db->quoteInto('recipe_id=?', $recipe->getRecipeID()) . 
                    ' AND ' . $db->quoteInto('image_id=?', $image->getImageID()));

        if(count($attached) == 0) {
            $sql = '
                INSERT INTO recipe_images (recipe_id, image_id)
                    VALUES (' . $db->quoteInto('?', $recipe->getRecipeID()) . ', ' . $db->quoteInto('?', $image->getImageID()) . ')';
            $db->query($sql);
        }
    }

    // }}}


    // Standard Mapper API
    // {{{ public Application_Model_DbTable_Recipe getDbTable()
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Recipe();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ public void fromDbObject(Application_Model_Recipe $recipe, $data)
	
	public function fromDbObject(Application_Model_Recipe $recipe, $data) {
		$this->fromDbArray($recipe, $data->toArray());
	}

    // }}}
    // {{{ public void fromDbArray(Application_Model_Recipe $recipe, array $data)
	
	public function fromDbArray(Application_Model_Recipe $recipe, array $data) {
        $data = array_map('stripslashes', $data);
		$recipe->setRecipeID($data['id'])
				->setTitle($data['title'])
				->setIntro($data['intro'])
				->setUrlTitle($data['url_title'])
				->setSource($data['source'])
				->setSourceURL($data['source_url'])
				->setBlog($data['blog'])
				->setBlogURL($data['blog_url'])
				->setUserID($data['user_id'])
				->setPreparationTime($data['preparation_time'])
				->setServes($data['serves'])
				->setViews($data['views'])
				->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
				->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601))
				->setCommunity(($data['is_community'] == 1 ? true : false))
				->setDeleted(($data['is_deleted'] == 1 ? true : false));
	}

    // }}}
    // {{{ public array toDbArray(Application_Model_Recipe $recipe)
	
	public function toDbArray(Application_Model_Recipe $recipe) {
		$data = array(
			'title'=>$recipe->getTitle(),
			'intro'=>$recipe->getIntro(),
			'url_title'=>$recipe->getUrlTitle(),
			'source'=>$recipe->getSource(),
			'source_url'=>$recipe->getSourceURL(),
			'blog'=>$recipe->getBlog(),
			'blog_url'=>$recipe->getBlogURL(),
			'user_id'=>$recipe->getUserID(),
			'preparation_time'=>$recipe->getPreparationTime(),
			'serves'=>$recipe->getServes(),
			'views'=>$recipe->getViews(),
			'created'=>($recipe->getCreated() ? $recipe->getCreated()->toString('yyyy-MM-dd HH:mm:ss') : ''),
			'modified'=>($recipe->getModified() ? $recipe->getModified()->toString('yyyy-MM-dd HH:mm:ss') : ''),
			'is_community'=>($recipe->isCommunity() ? 1 : 0),
			'is_deleted'=>($recipe->isDeleted() ? 1 : 0)
		);
		return $data;
	}
    
    // }}}
}

?>
