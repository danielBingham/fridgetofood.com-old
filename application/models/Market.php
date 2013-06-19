<?php
class Application_Model_Market extends Application_Model_Abstract {
	
	private $_marketID;
	private $_name;
	private $_description;
	private $_address;
	private $_email;
	private $_website;
	private $_openTimes;
	private $_startDate;
	private $_endDate;
	private $_created;
	private $_modified;
	private $_userID;
	
	// Associations
	private $_farms;
	private $_user;
	
	/****************************************************************************
	 * Associations
	 ****************************************************************************/
	public function getFarms() {
		if($this->lazyLoad()) {
			$this->getBuilder()->build('farms', $this);
		}
		return $this->_farms;
	}
	
	public function setFarms(array $farms) {
		$this->_farms = $farms;
		return $this;
	}
	
	public function getUser() {
		if($this->lazyLoad()) {
			$this->getBuilder()->build('user', $this);
		}
		return $this->_user;
	}
	
	public function setUser(Application_Model_User $user) {
		$this->_user = $user;
		$this->setUserID($user->getUserID());
		return $this;
	}
	
	
	/****************************************************************************
	 * Primary API
	 */
	
	public function __construct($lazy=true) {
		$this->_marketID=false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Market())
				->allowLazyLoad();
		}
	}
	
	public function getMarketID() {
		return $this->_marketID;
	}
	
	public function setMarketID($marketID) {
		$this->_marketID = $marketID;
		return $this;
	}
	
	public function getName() {
		return $this->_name;
	}

	public function setName($name) {
		$this->_name = $name;
		return $this;
	}
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function setDescription($description) {
		$this->_description = $description;
		return $this;
	}
	
	public function getAddress() {
		return $this->_address;
	}
	
	public function setAddress($address) {
		$this->_address = $address;
		return $this;
	}
	
	public function getEmail() {
		return $this->_email;
	}
	
	public function setEmail($email) {
		$this->_email = $email;
		return $this;
	}
	
	public function getWebsite() {
		return $this->_website;
	}
	
	public function setWebsite($website) {
		$this->_website = $website;
		return $this;
	}
	
	public function getOpenTimes() {
		return $this->_openTimes;
	}
	
	public function setOpenTimes($openTimes) {
		$this->_openTimes = $openTimes;
		return $this;
	}
	
	public function getStartDate() {
		return $this->_startDate;
	}
	
	public function setStartDate(Zend_Date $startDate) {
		$this->_startDate = $startDate;
		return $this;
	}
	
	public function getEndDate() {
		return $this->_endDate;
	}
	
	public function setEndDate(Zend_Date $endDate) {
		$this->_endDate = $endDate;
		return $this;
	}
	
	public function getCreated() {
		return $this->_created;
	}
	
	public function setCreated(Zend_Date $created) {
		$this->_created = $created;
		return $this;
	}
	
	public function getModified() {
		return $this->_modified;
	}
	
	public function setModified(Zend_Date $modified) {
		$this->_modified = $modified;
		return $this;
	}
}
?>	
