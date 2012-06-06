<?php

class Application_Model_RecipeComment extends Application_Model_Abstract {
	private $_recipeCommentID;
	private $_userID;
	private $_recipeID;
	private $_content;
	private $_created;
	private $_modified;
	
	// Associations
	private $_user;
	
	public function ensureSafeLoad() {
		if($this->_recipeCommentID === false) {
			throw new Exception('In order to load RecipeComment Associations a recipeCommentID must be set.');
		}
	}

	/****************************************************************************
	 * Associations
	 ****************************************************************************/
	
	public function getUser() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('user', $this);
		}
		return $this->_user;
	}
	
	public function setUser(Application_Model_User $user) {
		$this->_user = $user;
        $this->_userID = $user->getUserID();
		return $this;
	}
	
	
	/****************************************************************************
	 * Primary API
	 ****************************************************************************/
	
	public function __construct($lazy = true) {
		$this->_recipeCommentID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_RecipeComment())
				->allowLazyLoad();
		}
	}
	
	public function getRecipeCommentID() {
		return $this->_recipeCommentID;
	}
	
	public function setRecipeCommentID($recipeCommentID) {
		$this->_recipeCommentID = $recipeCommentID;
		return $this;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
		return $this;
	}
	
	public function getRecipeID() {
		return $this->_recipeID;
	}
	
	public function setRecipeID($recipeID) {
		$this->_recipeID = $recipeID;
		return $this;
	}

	public function getContent() {
		return $this->_content;
	}
	
	public function setContent($content) {
		$this->_content = $content;
		return $this;
	}
	
	public function getCreated() {
		return $this->_created;
	}
	
	public function setCreated($created) {
		$this->_created = $created;
		return $this;
	}
	
	public function getModified() {
		return $this->_modified;
	}
	
	public function setModified($modified) {
		$this->_modified = $modified;
		return $this;
	}
}

