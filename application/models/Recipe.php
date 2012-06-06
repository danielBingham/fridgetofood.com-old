<?php

class Application_Model_Recipe extends Application_Model_Abstract {

    // {{{ DB fields
	
    private $_recipeID;
	private $_title;
	private $_intro;
	private $_urlTitle;
	private $_source;
	private $_sourceURL;
	private $_blog;
	private $_blogURL;
	private $_userID;
	private $_preparationTime;
	private $_serves;
	private $_views;
	private $_created;
	private $_modified;
	private $_community;
	private $_deleted;

    // }}}
    // {{{ Virtual fields
	
	private $_voteTotal;
	private $_numberOfComments;

    // }}}
    // {{{ Associations
	
	private $_user;
	private $_images;
	private $_tags;
	private $_recipeSections;
	private $_recipeComments;

    // }}}

    // {{{ public ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_recipeID === false) {
			throw new Exception('In order to load Recipe Associations a recipeID must be set.');
		}
	}

    // }}}

    // Model Methods
    // {{{ public int getRecipeSectionCount()
        
    public function getRecipeSectionCount() {
       return count($this->_recipeSections);
    }
    
    // }}} 


	 // Associations
    // {{{ public getUser()

	public function getUser() {
		if(empty($this->_user) && $this->loadLazy()) {
			$this->getBuilder()->build('user', $this);
		}
		return $this->_user;
	}

    // }}}
    // {{{ public setUser(Application_Model_User $user)
	
	public function setUser(Application_Model_User $user) {
		$this->_user = $user;
		$this->_userID = $user->getUserID();
		return $this;
	}

    // }}}
    // {{{ public getImages()
    	
	public function getImages() {
		if(empty($this->_images) && $this->loadLazy()) {
			$this->getBuilder()->build('images', $this);
		}
		return $this->_images;
	}
    
    // }}}
    // {{{ public setImages(array $images)
	
	public function setImages(array $images) {
		foreach($images as $image) {
			if(!($image instanceof Application_Model_Image)) {
				throw new Exception('All images must be instances of Application_Model_Image.');
			}
		}
		$this->_images = $images;
		return $this;
	}

    // }}}
    // {{{ public getPrimaryImage()
	
	public function getPrimaryImage() {
		if(empty($this->_images) && $this->loadLazy()) {
			$this->getBuilder()->build('images', $this);
		}
		if(!empty($this->_images) && is_array($this->_images)) {
			return $this->_images[0];
		} else {
			return NULL;
		}	
	}

    // }}}
    // {{{ public getTags()
	
	public function getTags() {
		if(empty($this->_tags) && $this->loadLazy()) {
			$this->getBuilder()->build('tags', $this);
		}
		return $this->_tags;
	}
    
    // }}}
    // {{{ public setTags(array $tags)
	
	public function setTags(array $tags) {
		foreach($tags as $tag) {
			if(!($tag instanceof Application_Model_Tag)) {
				throw new Exception('All tags must be instances of Application_Model_Tag.');
			}
		}
		$this->_tags = $tags;
		return $this;
	}

    // }}}
    // {{{ public getRecipeSections()
	
	public function getRecipeSections() {
		if(empty($this->_recipeSections) && $this->loadLazy()) {
			$this->getBuilder()->build('recipeSections', $this);
		}
		if(empty($this->_recipeSections)) {
			return array();
		}
		return $this->_recipeSections;
	}
    
    // }}}
    // {{{ public setRecipeSections(array $recipeSections)
	
	public function setRecipeSections(array $recipeSections) {
		foreach($recipeSections as $recipeSection) {
			if(!($recipeSection instanceof Application_Model_RecipeSection)) {
				throw new Exception('All RecipeSections must be instances of Application_Model_RecipeSection.');
			}
		}
		$this->_recipeSections = $recipeSections;
		return $this;
	}

    // }}}
    // {{{ public getRecipeComments()
	
	public function getRecipeComments() {
		if(empty($this->_recipeComments) && $this->loadLazy()) {
			$this->getBuilder()->build('recipeComments', $this);
		}
		return $this->_recipeComments;
	}
    
    // }}}
    // {{{ public setRecipeComments(array $recipeComments)
	
	public function setRecipeComments(array $recipeComments) {
		foreach($recipeComments as $comment) {
			if(!($comment instanceof Application_Model_RecipeComment)) {
				throw new Exception('All RecipeComments must be instances of Application_Model_RecipeComment.');
			}
		}
		$this->_recipeComments = $recipeComments;
		return $this;
	}
	
    // }}} 
	
	 // Virtual API
    // {{{ public getVoteTotal()
	
	public function getVoteTotal() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_voteTotal;
	}

    // }}}
    // {{{ public setVoteTotal($voteTotal)
	
	public function setVoteTotal($voteTotal) {
		$this->_voteTotal = $voteTotal;
		return $this;
	}

    // }}}
    // {{{ public getNumberOfComments()
    	
	public function getNumberOfComments() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('virtualAPI', $this);
		}
		return $this->_numberOfComments;
	}
    
    // }}}
    // {{{ public setNumberOfComments($numberOfComments)
 	
	public function setNumberOfComments($numberOfComments) {
		$this->_numberOfComments = $numberOfComments;
		return $this;
	}

    // }}}
	
	 // Primary API
	// {{{ public __construct($lazy=true)

    public function __construct($lazy=true) {
		$this->_recipeID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Recipe())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ public getRecipeID()
	
	public function getRecipeID() {
		return $this->_recipeID;
	}

    // }}}
    // {{{ public setRecipeID($recipeID)
	
	public function setRecipeID($recipeID) {
		$this->_recipeID = $recipeID;
		return $this;
	}
    
    // }}}
    // {{{ public getTitle()
    	
	public function getTitle() {
		return $this->_title;
	}

    // }}}
    // {{{ public setTitle($title)
    	
	public function setTitle($title) {
		$this->_title = $title;
		return $this;
	}
    
    // }}}
    // {{{ public getIntro()
	
	public function getIntro() {
		return $this->_intro;
	}

    // }}}
    // {{{ public setIntro($intro)
	
	public function setIntro($intro) {
		$this->_intro = $intro;
		return $this;
	}

    // }}}
    // {{{ public getUrlTitle()
	
	public function getUrlTitle() {
		return $this->_urlTitle;
	}

    // }}}
    // {{{ public setUrlTitle($urlTitle)
	
	public function setUrlTitle($urlTitle) {
		$this->_urlTitle = $urlTitle;
		return $this;
	}

    // }}}	
    // {{{ public getSource()
	
    public function getSource() {
		return $this->_source;
	}

    // }}}
    // {{{ public setSource($source)
	
	public function setSource($source) {
		$this->_source = $source;
		return $this;
	}

    // }}}
    // {{{ public getSourceURL()
	
	public function getSourceURL() {
		return $this->_sourceURL;
	}

    // }}}
    // {{{ public setSourceURL($sourceURL)
    	
	public function setSourceURL($sourceURL) {
		$this->_sourceURL = $sourceURL;
		return $this;
	}

    // }}}
    // {{{ public getBlog()
    	
	public function getBlog() {
		return $this->_blog;
	}

    // }}}
    // {{{ public setBlog($blog)	
    
	public function setBlog($blog) {
		$this->_blog = $blog;
		return $this;
	}

    // }}}
    // {{{ public getBlogURL()
    	
	public function getBlogURL() {
		return $this->_blogURL;
	}

    // }}}
    // {{{ public setBlogURL($blogURL)
    	
	public function setBlogURL($blogURL) {
		$this->_blogURL = $blogURL;
		return $this;
	}

    // }}}
    // {{{ public getUserID()
    	
	public function getUserID() {
		return $this->_userID;
	}

    // }}}
    // {{{ public setUserID($userID)
    	
	public function setUserID($userID) {
		$this->_userID = $userID;
		return $this;
	}

    // }}}
    // {{{ public getPreparationTime()
	
	public function getPreparationTime() {
		return $this->_preparationTime;
	}

    // }}}
    // {{{ public setPreparationTime($preparationTime)
    	
	public function setPreparationTime($preparationTime) {
		$this->_preparationTime = $preparationTime;
		return $this;
	}

    // }}}
    // {{{ public getServes()
    	
	public function getServes() {
		return $this->_serves;
	}

    // }}}
    // {{{ public setServes($serves)
    	
	public function setServes($serves) {
		$this->_serves = $serves;
		return $this;
	}

    // }}}
    // {{{ public getViews()
	
	public function getViews() {
		return $this->_views;
	}

    // }}}
    // {{{ public setViews($views)
	
	public function setViews($views) {
		$this->_views = $views;
		return $this;
	}

    // }}}
    // {{{ public getCreated()
	
	public function getCreated() {
		return $this->_created;
	}

    // }}}
    // {{{ public setCreated(Zend_Date $created)
 	
	public function setCreated(Zend_Date $created) {
		$this->_created = $created;
		return $this;
	}

    // }}}
    // {{{ public getModified()
	
	public function getModified() {
		return $this->_modified;
	}

    // }}}
    // {{{ public setModified(Zend_Date $modified)
	
	public function setModified(Zend_Date $modified) {
		$this->_modified = $modified;
		return $this;
	}

    // }}}
    // {{{ public isCommunity()
	
	public function isCommunity() {
		return $this->_community;
	}

    // }}}
    // {{{ public setCommunity($community)
	
	public function setCommunity($community) {
		$this->_community = $community;
		return $this;
	}

    // }}}
    // {{{ public isDeleted()
	
	public function isDeleted() {
		return $this->_deleted;
	}

    // }}}
    // {{{ public setDeleted($deleted)
	
	public function setDeleted($deleted) {
		$this->_deleted = $deleted;
		return $this;
	}

    // }}}		
}
?>
