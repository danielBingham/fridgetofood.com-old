<?php

class Application_Model_SearchResult extends Application_Model_Abstract {
    
    // Primary Data 
    private $_searchResultsID;
    private $_searchID;
    private $_recipeID;
    private $_relevance;

    // Associations
    private $_search;
    private $_recipe;

    // {{{ public ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_searchResultID === false) {
			throw new Exception('In order to load SearchResult Associations a searchResultID must be set.');
		}
	}

    // }}}


    // Association Methods
    // {{{ getSearch():                                                     public Application_Model_Search

    public function getSearch() {
        if(empty($this->_search) && $this->loadLazy()) {
            $this->getBuilder()->build('search', $this);
        }
        return $this->_search;
    }

    // }}}
    // {{{ setSearch(Application_Model_Search $search):                     public void

    public function setSearch(Application_Model_Search $search) {
        $this->_search = $search;
        $this->_searchID = $search->getSearchID();
        return $this;
    }

    // }}}
    // {{{ getRecipe():                                                     public Application_Model_Recipe

    public function getRecipe() {
        if(empty($this->_recipe) && $this->loadLazy()) {
            $this->getBuilder()->build('recipe', $this);
        }
        return $this->_recipe;
    }

    // }}}
    // {{{ setRecipe(Application_Model_Recipe $recipe):                     public void

    public function setRecipe(Application_Model_Recipe $recipe) {
        $this->_recipe = $recipe;
        $this->_recipeID = $recipe->getRecipeID();
        return $this;
    }
    // }}}

    // {{{ __construct($lazy=true)
    
    public function __construct($lazy=true) {
        $this->_searchResultID = false;
        if($lazy) {
			$this->setBuilder(new Application_Model_Builder_SearchResult())
				->allowLazyLoad();
		}

    }

    // }}}

    // {{{ getSearchResultID():                                             public int

    public function getSearchResultID() {
        return $this->_searchResultID;
    }

    // }}}
    // {{{ setSearchResultID($searchResultID):                              public void

    public function setSearchResultID($searchResultID) {
        $this->_searchResultID = $searchResultID;
        return $this;
    }

    // }}}
    // {{{ getSearchID():                                                   public int

    public function getSearchID() {
        return $this->_searchID;
    }

    // }}}
    // {{{ setSearchID($searchID):                                          public void

    public function setSearchID($searchID) {
        $this->_searchID = $searchID;
        return $this;
    }

    // }}}
    // {{{ getRecipeID():                                                   public int

    public function getRecipeID() {
        return $this->_recipeID;
    }

    // }}}
    // {{{ setRecipeID($recipeID):                                          public void

    public function setRecipeID($recipeID) {
        $this->_recipeID = $recipeID;
        return $this;
    }

    // }}}
    // {{{ getRelevance():                                                  public float

    public function getRelevance() {
        return $this->_relevance;
    }

    // }}}
    // {{{ setRelevance($relevance):                                        public void

    public function setRelevance($relevance) {
        $this->_relevance = $relevance;
        return $this;
    }

    // }}}
     

}

