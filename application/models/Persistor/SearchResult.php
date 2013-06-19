<?php

class Application_Model_Persistor_SearchResult extends Application_Model_Persistor_Abstract {
    private $_mapper;

    // {{{ getMapper():                                                     protected Application_Model_Mapper_SearchResult
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_SearchResult(); 
        }
        return $this->_mapper;
    }

    // }}} 

    // {{{ save(Application_Model_SearchResult $searchResult):                          public void
    
    public function save(Application_Model_SearchResult $searchResult) {
        if($searchResult->getSearchResultID()) {
            $this->clear($searchResult);
            $this->update($searchResult);
        } else {
            $this->insert($searchResult);
        }
   }

    // }}}

    // {{{ delete(Application_Model_SearchResult $searchResult):                        public void

    public function delete(Application_Model_SearchResult $searchResult) {
        parent::deleteRaw($searchResult->getSearchResultID());
    }

    // }}}
    // {{{ insert(Application_Model_SearchResult $searchResult):                        protected void
    
    protected function insert(Application_Model_SearchResult $searchResult) {
        $data = $this->getMapper()->toDbArray($searchResult);
        $searchResult->setSearchResultID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_SearchResult $searchResult):                        protected void

    protected function update(Application_Model_SearchResult $searchResult) {
        $data = $this->getMapper()->toDbArray($searchResult);
        parent::updateRaw($data, $searchResult->getSearchResultID());
    }

    // }}}




}

?>
