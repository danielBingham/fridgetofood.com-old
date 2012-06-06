<?php

class Application_Model_User extends Application_Model_Abstract {
	private $_userID;
	private $_email;
	private $_password;
	private $_displayName;
	private $_reputation;
	private $_website;
	private $_websiteURL;
	private $_importBlog;
	private $_about;
	private $_imageID;
	private $_created;
	private $_seen;
	private $_notified;
	private $_modified;
	
	// Virtuals
	private $_recipeCount;
	
	// Associations
	private $_recipes;
    private $_images;
	private $_profileImage;
	private $_ribbons;
		
	public function updateReputation() {}
	
	public function ensureSafeLoad() {
		if($this->_userID === false) {
			throw new Exception('In order to load User Associations a userID must be set.');
		}
	}
	
	/****************************************************************************
	 * Associations
	 ****************************************************************************/	
	public function getRecipes() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('recipes', $this);
		}
		return $this->_recipes;
	}
	
	public function setRecipes(array $recipes) {
		foreach($recipes as $recipe) {
			if(!($recipe instanceof Application_Model_Recipe)) {
				throw new Exception('All recipes must be instances of Application_Model_Recipe.');
			}
		}
		$this->_recipes = $recipes;
		return $this;
	}

    public function getImages() {
        if($this->loadLazy()) {
            $this->getBuilder()->build('images', $this);
        }
        return $this->_images;
    }

    public function setImages(array $images) {
        foreach($images as $image) {
            if(!($image instanceof Application_Model_Image)) {
                throw new RuntimeException('All images must be instances of Application_Model_Image.');
            }
        }
        $this->_images = $images;
        return $this; 
    }
	
	public function getProfileImage() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('profileImage', $this);
		}
		return $this->_profileImage;
	}
	
	public function setProfileImage(Application_Model_Image $image) {
		$this->_profileImage = $image;
		$this->_imageID = $image->getImageID();
		return $this;
	}
	
	public function getRibbons() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('ribbons', $this);
		}
		return $this->_ribbons;
	}
	
	public function setRibbons(array $ribbons) {
		foreach($ribbons as $ribbon) {
			if(! ($ribbon instanceof Application_Model_Ribbon)) {
				throw new Exception('All ribbons must be instances of Application_Model_Ribbon.');
			}
		}
		$this->_ribbons = $ribbons;
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
	 * User's primary API
	 ****************************************************************************/
	
	public function __construct($lazy = true) {
		$this->_userID = false;
		$this->_password = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_User())
				->allowLazyLoad();
		}
	}
	
	public function __get($name) {
		$method = 'get' . ucfirst($name);
		if(!method_exists($this, $method)) {
			throw new RuntimeException('Attempt to access a non-existant propery.');
		} 
		return $this->$method();
	}
	
	public function __set($name, $value) {
		$method = 'set' . ucfirst($name);
		if(!method_exists($this, $method)) {
			throw new RuntimeException('Attempt to access a non-existent property with method ' . $method);	
		}
		$this->$method($value);
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
		return $this;
	}
	
	public function getEmail() {
		return $this->_email;
	}
	
	public function setEmail($email) {
		$this->_email = $email;
		return $this;
	}
	
	public function getPassword() {
		return $this->_password;
	}
	
	public function setPassword($password) {
		$this->_password = $password;
		return $this;
	}
	
	public function getDisplayName() {
		return $this->_displayName;
	}
	
	public function setDisplayName($displayName) {
		$this->_displayName = $displayName;
		return $this;
	}
	
	public function getReputation() {
		return $this->_reputation;
	}
	
	public function setReputation($reputation) {
		$this->_reputation = $reputation;
		return $this;
	}
	
	public function getWebsite() {
		return $this->_website;
	}
	
	public function setWebsite($website) {
		$this->_website = $website;
		return $this;
	}
	
	public function getWebsiteURL() {
		return $this->_websiteURL;
	}
	
	public function setWebsiteURL($websiteURL) {
		$this->_websiteURL = $websiteURL;
		return $this;
	}
	
	public function wantsBlogImport() {
		return $this->_importBlog;
	}
	
	public function setBlogImport($importBlog) {
		$this->_importBlog = $importBlog;
		return $this;
	}
	
	public function getAbout() {
		return $this->_about;
	}
	
	public function setAbout($about) {
		$this->_about = $about;
		return $this;
	}
	
	public function getImageID() {
		return $this->_imageID;
	}
	
	public function setImageID($imageID) {
		$this->_imageID = $imageID;
		return $this;
	}
	
	public function getCreated() {
		return $this->_created;
	}
	
	public function setCreated($created) {
		$this->_created = $created;
		return $this;
	}
	
	public function getSeen() {
		return $this->_seen;
	}
	
	public function setSeen($seen) {
		$this->_seen = $seen;
		return $this;
	}
	
	public function getNotified() {
		return $this->_notified;
	}
	
	public function setNotified($notified) {
		$this->_notified = $notified;
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

