<?php

class Application_Model_Mapper_SearchResult {
	private $_dbTable;

    // Standard Mapper API
    // {{{ public Application_Model_DbTable_SearchResult getDbTable()
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_SearchResult();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ public void fromDbObject(Application_Model_SearchResult $searchResult, $data)
	
	public function fromDbObject(Application_Model_SearchResult $searchResult, $data) {
		$this->fromDbArray($searchResult, $data->toArray());
	}

    // }}}
    // {{{ public void fromDbArray(Application_Model_SearchResult $searchResult, array $data)
	
	public function fromDbArray(Application_Model_SearchResult $searchResult, array $data) {
        $data = array_map('stripslashes', $data);
		$searchResult->setSearchResultID($data['id'])
                    ->setRecipeID($data['recipe_id'])
                    ->setSearchID($data['search_id'])
                    ->setRelevance($data['relevance']);	

    }

    // }}}
    // {{{ public array toDbArray(Application_Model_SearchResult $searchResult)
	
	public function toDbArray(Application_Model_SearchResult $searchResult) {
		$data = array(
            'recipe_id'=>$searchResult->getRecipeID(),
            'search_id'=>$searchResult->getSearchID(),
            'relevance'=>$searchResult->getRelevance()
		);
		return $data;
	}
    
    // }}}
}

