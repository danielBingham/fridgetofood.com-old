<?php
class Application_Model_Mapper_Ribbon {

    // {{{ grantRibbonToUser(Application_Model_Ribbon $ribbon, Application_Model_User $user):   public void
    
    public function grantRibbonToUser(Application_Model_Ribbon $ribbon, Application_Model_User $user) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $sql = 'INSERT INTO user_ribbons (user_id, ribbon_id, created, modified)
                        VALUES (' . $db->quoteInto('?', $user->getUserID()) . ', ' . $db->quoteInto('?', $ribbon->getRibbonID()) . ', NOW(), NOW())';
        $db->query($sql);
    }

    // }}}
	
	// Standard Mapper API
    // {{{ getDbTable():        `                                           public Application_Model_DbTable_Ribbon
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Ribbon();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ fromDbObject(Application_Model_Ribbon $ribbon, $data):           public void
	
    public function fromDbObject(Application_Model_Ribbon $ribbon, $data) {
		$this->fromDbArray($ribbon, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_Ribbon $ribbon, array $data):      public void
	
	public function fromDbArray(Application_Model_Ribbon $ribbon, array $data) {
		$ribbon->setRibbonID($data['id'])
				->setName($data['name'])
				->setDisplayName($data['display_name'])
				->setDescription($data['description'])
				->setType($data['type'])
				->setRepeatable($data['repeatable']);
		
	}

    // }}}
    // {{{ toDbArray(Application_Model_Ribbon $ribbon):                     public array
	
	public function toDbArray(Application_Model_Ribbon $ribbon) {
		$data = array(
			'name'=>$ribbon->getName(),
			'display_name'=>$ribbon->getDisplayName(),
			'description'=>$ribbon->getDescription(),
			'type'=>$ribbon->getType(),
			'repeatable'=>$ribbon->getRepeatable()
		);
		return $data;
	}
    
    // }}}
}
?>
