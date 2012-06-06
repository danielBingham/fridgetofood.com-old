<?php

class Application_Model_Image extends Application_Model_Abstract {
	private $_imageID;
	private $_userID;
	private $_width;
	private $_height;
	private $_views;
	private $_created;
	private $_modified;
	
	// Virtual
	private $_votes;
	
	// Associations
	private $_recipe;
	private $_farm;
	private $_user;
	
	public function ensureSafeLoad() {
		if($this->_imageID === false) {
			throw new Exception('In order to load Image Associations a imageID must be set.');
		}
	}

	
	public function fileExists($size='medium') {
		$path = '/srv/www/img.fridgetofood.com/' . $size . '/' . $this->getImageID() . '.jpg';
		return file_exists($path);
		
	}
	
	/****************************************************************************
	 * Associations
	 ****************************************************************************/
	
	public function getRecipe() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('recipe', $this);
		}
		return $this->_recipe;
	}
	
	public function setRecipe(Application_Model_Recipe $recipe) {
		$this->_recipe = $recipe;
		return $this;
	}
	
	public function getUser() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('user', $this);
		}
		return $this->_user;
	}
	
	public function setUser(Application_Model_User $user) {
		$this->_user = $user;
		return $this;
	}
	
	public function getFarm() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('farm', $this);
		}
		return $this->_farm;
	}
	
	public function setFarm(Application_Model_Farm $farm) {
		$this->_farm = $farm;
		return $this;
	}
	
	
	/****************************************************************************
	 * Virtual API
	 ****************************************************************************/
	public function getVotes() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_votes;
	}
	
	public function setVotes($votes) {
		$this->_votes = $votes;
		return $this;
	}
	
	/****************************************************************************
	 * Standard API
	 ****************************************************************************/
	
	
	public function __construct($lazy=true) {
		$this->_imageID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Image())
				->allowLazyLoad();	
		}
	
	}
	
	public function getImageID() {
		return $this->_imageID;
	}
	
	public function setImageID($imageID) {
		$this->_imageID = $imageID;
		return $this;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
		return $this;
	}
	
	public function getWidth() {
		return $this->_width;
	}
	
	public function setWidth($width) {
		$this->_width = $width;
		return $this;
	}
	
	public function getHeight() {
		return $this->_height;
	}
	
	public function setHeight($height) {
		$this->_height = $height;
		return $this;
	}
	
	public function getViews() {
		return $this->_views;
	}
	
	public function setViews($views) {
		$this->_views = $views;
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

