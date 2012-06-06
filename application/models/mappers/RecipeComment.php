<?php
/**
*
*/
class Application_Model_Mapper_RecipeComment {

	private $_dbTable;

    // {{{ getDbTable():                                                                            public Application_Model_DbTable_RecipeComment
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_RecipeComment();
		}
		return $this->_dbTable;
	}	

    // }}}
    // {{{ fromDbObject(Application_Model_RecipeComment $recipeComment, $data):                     public void
	
	public function fromDbObject(Application_Model_RecipeComment $recipeComment, $data) {
		$this->fromDbArray($recipeComment, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_RecipeComment $recipeComment, array $data):                public void
	
	public function fromDbArray(Application_Model_RecipeComment $recipeComment, array $data) {
		$recipeComment->setRecipeCommentID($data['id'])
					->setUserID($data['user_id'])
					->setRecipeID($data['recipe_id'])
					->setContent($data['content'])
					->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
					->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601));

	}

    // }}}
    // {{{ toDbArray(Application_Model_RecipeComment $recipeComment):                               public array(mixed)
	
	public function toDbArray(Application_Model_RecipeComment $recipeComment) {
		$data = array(
			'user_id'=>$recipeComment->getUserID(),
			'recipe_id'=>$recipeComment->getRecipeID(),
			'content'=>$recipeComment->getContent(),
			'created'=>($recipeComment->getCreated() instanceof Zend_Date ? $recipeComment->getCreated()->toString('yyyy-MM-dd HH:mm:ss') : ''),
			'modified'=>($recipeComment->getModified() instanceof Zend_Date ? $recipeComment->getModified()->toString('yyyy-MM-dd HH:mm:ss') : ''),
		);
		return $data;
	}

    // }}}

}
?>
