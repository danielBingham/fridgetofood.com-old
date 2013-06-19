<?php
class Application_Model_Farm extends Application_Model_Abstract {
	
	private $_farmID;
	private $_name;
	private $_description;
	private $_website;
	private $_email;
	private $_phone;
	private $_address;
	private $_openTimes;
	private $_userID;
	private $_views;
	private $_created;
	private $_modified;
	
	// Virtuals
	private $_numberOfComments;
	private $_numberOfProducts;
	
	// Associations
	private $_products;
	private $_tags;
	private $_images;
	private $_markets;
	private $_comments;
	
	public function ensureSafeLoad() {
		if($this->_farmID === false) {
			throw new Exception('In order to load Farm Associations a farmID must be set.');
		}
	}
	
	
	/****************************************************************************
	 * Associations
	 ****************************************************************************/
	public function getProducts() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('products', $this);
		}
		return $this->_products;
	}
	
	public function setProducts(array $products) {
		$this->_products = $products;
		return $this;
	}
	
	public function getTags() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('tags', $this);
		}

		return $this->_tags;
	}
	
	public function setTags(array $tags) {
		$this->_tags = $tags;
		return $this;
	}
	
	public function getPrimaryImage() {
		$images = $this->getImages();
		if(empty($images) || !is_array($images)) {
			return null;
		} else {
			return $images[0];
		}
	}
	
	public function getImages() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('images', $this);
		}
		return $this->_images;
	}
	
	public function setImages(array $images) {
		$this->_images = $images;
		return $this;
	}
	
	public function getMarkets() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('markets', $this);
		}
		return $this->_markets;
	}
	
	public function setMarkets(array $markets) {
		$this->_markets = $markets;
		return $this;
	}
	
	public function getComments() {
		return $this->_comments;
	}
	
	public function setComments($comments) {
		if($this->loadLazy()) {
			$this->getBuilder()->build('comments', $this);
		}
		return $this->_comments;
	}
	
	/****************************************************************************
	 * Virtual API
	 ****************************************************************************/
	
	public function getNumberOfComments() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_numberOfComments;
	}
	
	public function setNumberOfComments($numberOfComments) {
		$this->_numberOfComments = $numberOfComments;
		return $this;
	}
	
	public function getNumberOfProducts() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_numberOfProducts;
	}
	
	public function setNumberOfProducts($numberOfProducts) {
		$this->_numberOfProducts = $numberOfProducts;
		return $this;
	}
	
	/****************************************************************************
	 * Primary API
	 ****************************************************************************/
	
	/**
	 * Build a Farm model, and determine whether or not this model should have
	 * lazy loading active.
	 * 
	 * @param boolean $lazy Allow lazy loading for this model.
	 */
	public function __construct($lazy=true) {
		$this->_farmID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Farm())
				->allowLazyLoad();
		}
	}
	
	public function getFarmID() {
		return $this->_farmID;
	}
	
	public function setFarmID($farmID) {
		$this->_farmID = $farmID;
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
	
	public function getWebsite() {
		return $this->_website;
	}
	
	public function setWebsite($website) {
		$this->_website = $website;
		return $this;
	}
	
	public function getEmail() {
		return $this->_email;
	}
	
	public function setEmail($email) {
		$this->_email = $email;
		return $this;
	}
	
	public function getPhone() {
		return $this->_phone;
	}
	
	public function setPhone($phone) {
		$this->_phone = $phone;
		return $this;
	}
	
	public function getAddress() {
		return $this->_address;
	}
	
	public function setAddress($address) {
		$this->_address = $address;
		return $this;
	}
	
	public function getOpenTimes() {
		return $this->_openTimes;
	}
	
	public function setOpenTimes($openTimes) {
		$this->_openTimes = $openTimes;
		return $this;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
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