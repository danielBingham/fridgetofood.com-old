<?php

class Application_Model_FarmComment extends Application_Model_Abstract {
	private $_farmCommentID;
	private $_userID;
	private $_farmID;
	private $_content;
	private $_created;
	private $_modified;
	
	// Associations
	private $_user;
	
	public function ensureSafeLoad() {
		if($this->_farmCommentID === false) {
			throw new Exception('In order to load FarmComment Associations a farmCommentID must be set.');
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
		return $this;
	}
	
	
	/****************************************************************************
	 * Primary API
	 ****************************************************************************/
	
	public function __construct($lazy = true) {
		$this->_farmCommentID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_FarmComment())
				->allowLazyLoad();
		}
	}
	
	public function getFarmCommentID() {
		return $this->_farmCommentID;
	}
	
	public function setFarmCommentID($farmCommentID) {
		$this->_farmCommentID = $farmCommentID;
		return $this;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
		return $this;
	}
	
	public function getFarmID() {
		return $this->_farmID;
	}
	
	public function setFarmID($farmID) {
		$this->_farmID = $farmID;
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