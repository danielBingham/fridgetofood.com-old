<?php

class Application_Model_Search extends Application_Model_Abstract {
  
    // Primary Data 
    private $_searchID;
    private $_query;
    private $_created;
    private $_used;
    private $_type;

    // Associations
    private $_searchResults;

    // {{{ public ensureSafeLoad()
	
	public function ensureSafeLoad() {
		if($this->_searchID === false) {
			throw new Exception('In order to load Search Associations a searchID must be set.');
		}
	}

    // }}}


    // Association Methods
    // {{{ getSearchResults():                                              public array(Application_Model_SearchResults)

    public function getSearchResults() {
        if(empty($this->_searchResults) && $this->loadLazy()) {
            $this->getBuilder()->build('searchResults', $this);
        }
        return $this->_searchResults;
    }

    // }}}
    // {{{ setSearchResults(array $searchResults):                          public void

    public function setSearchResults(array $searchResults) {
        $this->_searchResults = $searchResults;
        return $this;
    }

    // }}}
    

    // {{{ __construct($lazy=true)

    public function __construct($lazy=true) {
		$this->_searchID= false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_Search())
				->allowLazyLoad();
		}
	}

    // }}}
    // {{{ getSearchID()                                                    public int

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
    // {{{ getQuery():                                                      public string 

    public function getQuery() {
        return $this->_query;
    }

    // }}}
    // {{{ setQuery($query):                                                public void    

    public function setQuery($query) {
        $this->_query = $query;
        return $this;
    }

    // }}}
    // {{{ getCreated():                                                    public Zend_Date

    public function getCreated() {
        return $this->_created; 
    }

    // }}}
    // {{{ setCreated(Zend_Date $created);                                  public void

    public function setCreated(Zend_Date $created) {
        $this->_created = $created;
        return $this;
    }

    // }}}
    // {{{ getUsed():                                                       public boolean

    public function getUsed() {
        return $this->_used;
    }

    // }}}
    // {{{ setUsed($used):                                                  public void

    public function setUsed($used) {
        $this->_used = $used;
        return $this;
    }

    // }}}
    // {{{ getType():                                                       public string 

    public function getType() {
        return $this->_type;
    }

    // }}}
    // {{{ setType($type):                                                  public void

    public function setType($type) {
        $this->_type = $type;
        return $this;
    }

    // }}}

}

?>
