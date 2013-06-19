<?php
/**
*
*/
class Application_Model_RecipeSection extends Application_Model_Abstract {
	private $_recipeSectionID;
	private $_recipeID;
	private $_title;
	private $_position;
	private $_main;
	
	// Associations
	private $_recipeIngredients;
	private $_recipeInstructions;

    // {{{ public void ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_recipeSectionID === false) {
			throw new Exception('In order to load RecipeSection Associations a recipeSectionID must be set.');
		}
	}

    // }}}
    

    // Model Methods
    // {{{ public boolean hasIngredients()
    
    public function hasIngredients() {

        if($this->getIngredientCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
   
     // }}}
    // {{{ public boolean hasInstructions()

    public function hasInstructions() {
        if($this->getInstructionCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // }}}	
    // {{{ public int getIngredientCount()
 
    public function getIngredientCount() {
		if(empty($this->_recipeIngredients) && $this->loadLazy()) {
			$this->getBuilder()->build('recipeIngredients', $this);
		}
        return count($this->_recipeIngredients);
    }

    // }}}	
    // {{{ public int getInstructionCount()
    
    public function getInstructionCount() {
        if(empty($this->_recipeInstructions) && $this->loadLazy()) {
            $this->getBuilder()->build('recipeInstructions', $this);
        }
        return count($this->_recipeInstructions);
    }

    // }}}
 
    // Associations
    // {{{ public array getRecipeIngredients()

	public function getRecipeIngredients() {
		if(empty($this->_recipeIngredients) && $this->loadLazy()) {
			$this->getBuilder()->build('recipeIngredients', $this);
		}
		return $this->_recipeIngredients;
	}

    // }}} 
    // {{{ public $this setRecipeIngredients(array $recipeIngredients)
	
	public function setRecipeIngredients(array $recipeIngredients) {
		$this->_recipeIngredients = $recipeIngredients;
		return $this;
	}

    // }}}
    // {{{ public array getRecipeInstruction()
	
	public function getRecipeInstructions() {
		if(empty($this->_recipeInstructions) && $this->loadLazy()) {
			$this->getBuilder()->build('recipeInstructions', $this);
		}
		return $this->_recipeInstructions;
	}

    // }}}
    // {{{ public $this setRecipeInstructions(array $recipeInstructions)
	
	public function setRecipeInstructions(array $recipeInstructions) {
		$this->_recipeInstructions = array();
		foreach($recipeInstructions as $instruction) {
			if(!($instruction instanceof Application_Model_RecipeInstruction)) {
				throw new Exception('All instructions must be instances of Application_Model_RecipeInstruction.');
			}
			$this->_recipeInstructions[(int)$instruction->getNumber()] = $instruction;
		}
		ksort($this->_recipeInstructions);
		return $this;
	}

    // }}}
	
    // Primary API
    // {{{ public void  __construct($lazy=true)

	public function __construct($lazy = true) {
		$this->_recipeSectionID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_RecipeSection())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ public int getRecipeSectionID()
	
	public function getRecipeSectionID() {
		return $this->_recipeSectionID;
	}

    // }}}
    // {{{ public $this setRecipeSectionID($recipeSectionID)
	
	public function setRecipeSectionID($recipeSectionID) {
		$this->_recipeSectionID = $recipeSectionID;
		return $this;
	}

    // }}}
    // {{{ public int getRecipeID()
	
	public function getRecipeID() {
		return $this->_recipeID;
	}

    // }}}
    // {{{ public $this setRecipeID($recipeID)
	
	public function setRecipeID($recipeID) {
		$this->_recipeID = $recipeID;
		return $this;
	}

    // }}}
    // {{{ public string getTitle()
    	
	public function getTitle() {
		return $this->_title;
	}

    // }}}
    // {{{ public $this setTitle($title)
	
	public function setTitle($title) {
		$this->_title = $title;
		return $this;
	}

    // }}}
    // {{{ public int getPosition()
	
	public function getPosition() {
		return $this->_position;
	}

    // }}}
    // {{{ public $this setPosition($position)
	
	public function setPosition($position) {
		$this->_position = $position;
		return $this;
	}

    // }}}
    // {{{ public boolean isMain()
	
	public function isMain() {
		return $this->_main;
	}

    // }}}
    // {{{ public $this setMain($main)
	
	public function setMain($main) {
		$this->_main = $main;
		return $this;
	}
    
    // }}}	
	
}

