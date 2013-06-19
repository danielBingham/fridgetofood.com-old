<?php

class Application_Model_Mapper_Search {
	private $_dbTable;

    // Standard Mapper API
    // {{{ public Application_Model_DbTable_Search getDbTable()
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Search();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ public void fromDbObject(Application_Model_Search $search, $data)
	
	public function fromDbObject(Application_Model_Search $search, $data) {
		$this->fromDbArray($search, $data->toArray());
	}

    // }}}
    // {{{ public void fromDbArray(Application_Model_Search $search, array $data)
	
	public function fromDbArray(Application_Model_Search $search, array $data) {
        $data = array_map('stripslashes', $data);
		$search->setSearchID($data['id'])
                ->setQuery($data['query'])
                ->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
                ->setUsed(($data['used'] ? true : false))
                ->setType($data['type']);
	}

    // }}}
    // {{{ public array toDbArray(Application_Model_Search $search)
	
	public function toDbArray(Application_Model_Search $search) {
		$data = array(
            'query'=>$search->getQuery(),
            'created'=>($search->getCreated() ? $search->getCreated()->toString('YYYY-MM-dd HH:mm:ss') : ''),
            'used'=>$search->getUsed(),
            'type'=>$search->getType() 
        );
		return $data;
	}
    
    // }}}
}

?>
