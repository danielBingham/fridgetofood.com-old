<?php
/**
*
*/
class Application_Model_Ingredient extends Application_Model_Abstract {
	private $_ingredientID;
	private $_name;
	private $_description;
	
	// Virtual 
	private $_recipeCount;
	
	// Association
	private $_images;

    // {{{ public ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_ingredientID === false) {
			throw new Exception('In order to load Ingredient Associations an ingredientID must be set.');
		}
	}

    // }}}
	
    // Associations
    // {{{ public getPrimaryImage()

	public function getPrimaryImage() {
		$images = $this->getImages();
		if(empty($images)) {
			return null;
		}
		return $images[0];
	}

    // }}}
    // {{{ public getImages()
	
	public function getImages() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('images', $this);
		}
		return $this->_images;
	}

    // }}}
    // {{{ public setImages(array $images)
	
	public function setImages(array $images) {
		$this->_images = $images;
		return $this;
	}

    // }}}	
	
	// Virtual API
    // {{{ public getRecipeCount()
 
    public function getRecipeCount() {
        if($this->loadLazy()) {
            $this->getBuilder()->build('virtualAPI', $this);
        }
        return $this->_recipeCount;
    }

    // }}}
    // {{{ public setRecipeCount($recipeCount)

	public function setRecipeCount($recipeCount) {
		$this->_recipeCount = $recipeCount;
		return $this;
	}

    // }}}	
	
	// Primary API
    // {{{ public __construct($lazy=true)

	public function __construct($lazy=true) {
		$this->_ingredientID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Ingredient())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ public getIngredientID()
	
	public function getIngredientID() {
		return $this->_ingredientID;
	}

    // }}}
    // {{{ public setIngredientID($ingredientID)
	
	public function setIngredientID($ingredientID) {
		$this->_ingredientID = $ingredientID;
		return $this;
	}

    // }}}
    // {{{ public getName()
	
	public function getName() {
		return $this->_name;
	}

    // }}}
    // {{{ public setName($name)	

	public function setName($name) {
		$this->_name = $name;
		return $this;
	}

    // }}}
    // {{{ public getDescription()
	
	public function getDescription() {
		return $this->_description;
	}

    // }}}
    // {{{ public setDescription($description)
	
	public function setDescription($description) {
		$this->_description = $description;
		return $this;
	}

    // }}}

}

?>
