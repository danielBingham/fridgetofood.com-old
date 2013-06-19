<?php

class Application_Model_RecipeInstruction extends Application_Model_Abstract {
	private $_recipeInstructionID;
	private $_recipeID;
	private $_recipeSectionID;
	private $_number;
	private $_content;

    // {{{ public ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_recipeInstructionID === false) {
			throw new Exception('In order to load RecipeInstruction Associations a recipeInstructionID must be set.');
		}
	}

    // }}}
	
	// Standard API
    // {{{ public __construct($lazy=true)	
    
    public function __construct($lazy = true) {
		$this->_recipeInstructionID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_RecipeInstruction())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ public getRecipeInstructionID()
	
	public function getRecipeInstructionID() {
		return $this->_recipeInstructionID;
	}

    // }}} 
    // {{{ public setRecipeInstructionID($recipeInstructionID)
	
	public function setRecipeInstructionID($recipeInstructionID) {
		$this->_recipeInstructionID = $recipeInstructionID;
		return $this;
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
    // {{{ public getRecipeSectionID()
     	
	public function getRecipeSectionID() {
		return $this->_recipeSectionID;
	}

    // }}}
    // {{{ public setRecipeSectionID($recipeSectionID)
    	
	public function setRecipeSectionID($recipeSectionID) {
		$this->_recipeSectionID = $recipeSectionID;
		return $this;
	}

    // }}}
    // {{{ public getNumber()
    	
	public function getNumber() {
		return $this->_number;
	}

    // }}}
    // {{{ public setNumber($number)
    	
	public function setNumber($number) {
		$this->_number = $number;
		return $this;
	}

    // }}}
    // {{{ public getContent()
	
	public function getContent() {
		return $this->_content;
	}

    // }}} 
    // {{{ public setContent($content)
	
	public function setContent($content) {
		$this->_content = $content;
		return $this;
	}

    // }}}

}

