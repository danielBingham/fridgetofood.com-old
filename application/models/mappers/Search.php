<?php

class Application_Model_Mapper_Search extends Application_Model_Mapper_Base {

    // {{{ public void fromDbArray(Application_Model_Search $search, array $data)
	
	public function fromDbArray(Application_Model_Search $search, array $data) {
        parent::fromDbArray($search, $data);
        $search->created = new Zend_Date($search->created, Zend_Date::ISO_8601);
	}

    // }}}
    // {{{ public array toDbArray(Application_Model_Search $search)
	
	public function toDbArray(Application_Model_Search $search) {
        $data = parent::toDbArray($search);
        $data['created'] = ($data['created'] ? $data['created']->toString('YYYY-MM-dd HH:mm:ss') : '');
	}
    
    // }}}
}

?>
