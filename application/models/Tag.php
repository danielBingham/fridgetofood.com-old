<?php

class Application_Model_Tag extends Application_Model_Abstract {
	private $_tagID;
	private $_name;
	private $_type;
	private $_description;
	private $_revision;
	private $_userID;
	private $_created;
	private $_modified;

	
	// Virtual
	private $_recipeCount;
	
	// Associations
	private $_user;
	private $_recipes;
	
	public function ensureSafeLoad() {
		if($this->_tagID === false) {
			throw new Exception('In order to load Tag Associations a tagID must be set.');
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
		$this->_userID = $user->getUserID();
		$this->_user = $user;
		return $this;
	}
	
	public function getRecipes() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('recipes', $this);
		}
		return $this->_recipes;
	}
	
	public function setRecipes($recipes) {
		$this->_recipes = $recipes;
		return $this;
	}
	
	/****************************************************************************
	 * Virtual API
	 ****************************************************************************/
	
	public function getRecipeCount() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_recipeCount;
	}
	
	public function setRecipeCount($recipeCount) {
		$this->_recipeCount = $recipeCount;
		return $this;
	}
	
	
	/****************************************************************************
	 * Primary API
	 ****************************************************************************/
	
	public function __construct($lazy = true) {
		$this->_tagID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Tag())
				->allowLazyLoad();
		}
	}
	
	public function getTagID() {
		return $this->_tagID;
	}
	
	public function setTagID($tagID) {
		$this->_tagID = $tagID;
		return $this;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function setName($name) {
		$this->_name = $name;
		return $this;
	}
	
	public function getType() {
		return $this->_type;
	}
	
	public function setType($type) {
		$this->_type = $type;
		return $this;
	}
	
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function setDescription($description) {
		$this->_description = $description;
		return $this;
	}
	
	public function getRevision() {
		return $this->_revision;
	}
	
	public function setRevision($revision) {
		$this->_revision = $revision;
		return $this;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
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

