<?php

class Application_Model_RecipeIngredient extends Application_Model_Abstract {
	private $_recipeIngredientID;
	private $_recipeID;
	private $_recipeSectionID;
	private $_ingredientID;
	private $_preparation;
	private $_amount;
	
	// Associations
	private $_ingredient;

    // {{{ ensureSafeLoad():                                            public void
	
	public function ensureSafeLoad() {
		if($this->_recipeIngredientID === false) {
			throw new Exception('In order to load Recipe Associations a recipeID must be set.');
		}
	}

    // }}}
	
    // Associations
    // {{{ getIngredient():                                             public Application_Model_Ingredient

	public function getIngredient() {
		if(empty($this->_ingredient) && $this->loadLazy()) {
			$this->getBuilder()->build('ingredient', $this);
		}
		return $this->_ingredient;
	}

    // }}}
    // {{{ setIngredient(Application_Model_Ingredient $ingredient):     public void
	
	public function setIngredient(Application_Model_Ingredient $ingredient) {
		$this->_ingredient = $ingredient;
		$this->_ingredientID = $ingredient->getIngredientID();
		return $this;
	}

    // }}}
	
	// Primary API
    // {{{ __construct($lazy)

	public function __construct($lazy = true) {
		$this->_recipeIngredientID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_RecipeIngredient())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ getRecipeIngredient():                                       public int
	
	public function getRecipeIngredientID() {
		return $this->_recipeIngredientID;
	}

    // }}}
    // {{{ setRecipeIngredientID($recipeIngredientID):                  public $this
	
	public function setRecipeIngredientID($recipeIngredientID) {
		$this->_recipeIngredientID = $recipeIngredientID;
		return $this;
	}
    
    // }}}
    // {{{ getRecipeID():                                               public int
	
	public function getRecipeID() {
		return $this->_recipeID;
	}
    
    // }}}
    // {{{ setRecipeID($recipeID):                                      public $this
	
	public function setRecipeID($recipeID) {
		$this->_recipeID = $recipeID;
		return $this;
	}
    
    // }}}
    // {{{ getRecipeSectionID():                                        public int
	
	public function getRecipeSectionID() {
		return $this->_recipeSectionID;
	}

    // }}}
    // {{{ setRecipeSectionID($recipeSectionID):                        public $this
	
	public function setRecipeSectionID($recipeSectionID) {
		$this->_recipeSectionID = $recipeSectionID;
		return $this;
	}

    // }}}
    // {{{ getIngredientID():                                           public int
	
	public function getIngredientID() {
		return $this->_ingredientID;
	}

    // }}}
    // {{{ setIngredientID($ingredientID):                              public $this
	
	public function setIngredientID($ingredientID) {
		$this->_ingredientID = $ingredientID;
		return $this;
	}

    // }}}  
    // {{{ getPreparation():                                            public string
	
	public function getPreparation() {
		return $this->_preparation;
	}

    // }}}
    // {{{ setPreparation($preparation):                                public $this
    	
	public function setPreparation($preparation) {
		$this->_preparation = $preparation;
		return $this;
	}

    // }}}
    // {{{ getAmount():                                                 public string
	
	public function getAmount() {
		return $this->_amount;
	}

    // }}}
    // {{{ setAmount($amount):                                          public $this
	
	public function setAmount($amount) {
		$this->_amount = $amount;
		return $this;
	}

    // }}}
}

