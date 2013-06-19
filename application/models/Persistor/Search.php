<?php

class Application_Model_Persistor_Search extends Application_Model_Persistor_Abstract {
    private $_mapper;

    // {{{ getMapper():                                                     protected Application_Model_Mapper_Search
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_Search(); 
        }
        return $this->_mapper;
    }

    // }}} 

    // {{{ save(Application_Model_Search $search):                          public void
    
    public function save(Application_Model_Search $search) {
        if($search->getSearchID()) {
            $this->clear($search);
            $this->update($search);
        } else {
            $this->insert($search);
        }

        $persistor = new Application_Model_Persistor_SearchResult();
        foreach($search->getSearchResults() as $searchResult) {
            $searchResult->setSearchID($search->getSearchID());
            $persistor->save($searchResult);
        }
   }

    // }}}

    // {{{ insert(Application_Model_Search $search):                        protected void
    
    protected function insert(Application_Model_Search $search) {
        $data = $this->getMapper()->toDbArray($search);
        $search->setSearchID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_Search $search):                        protected void

    protected function update(Application_Model_Search $search) {
        $data = $this->getMapper()->toDbArray($search);
        parent::updateRaw($data, $search->getSearchID());
    }

    // }}}


}

?>
