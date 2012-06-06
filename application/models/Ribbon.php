<?php

class Application_Model_Ribbon {
	private $_ribbonID;
	private $_name;
	private $_displayName;
	private $_description;
	private $_type;
	private $_repeatable;
	
	public function getNumberEarned() {
		return Application_Model_Query_Ribbon::getInstance()->getNumberEarned($this);
	}
	
	/****************************************************************************
	 * Basic Model Methods
	 ****************************************************************************/
	
	public function __construct() {}
	
	public function getRibbonID() {
		return $this->_ribbonID;
	}
	
	public function setRibbonID($ribbonID) {
		$this->_ribbonID = $ribbonID;
		return $this;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function setName($name) {
		$this->_name = $name;
		return $this;
	}
	
	public function getDisplayName() {
		return $this->_displayName;
	}
	
	public function setDisplayName($displayName) {
		$this->_displayName = $displayName;
		return $this;
	}
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function setDescription($description) {
		$this->_description = $description;
		return $this;
	}
	
	public function getType() {
		return $this->_type;
	}
	
	public function setType($type) {
		$this->_type = $type;
		return $this;
	}
	
	public function isRepeatable() {
		return $this->_repeatable;
	}
	
	public function setRepeatable($repeatable) {
		$this->_repeatable = $repeatable;
		return $this;	
	}


}

