<?php
class Application_Model_Mapper_Ingredient {
	
    // {{{ populateVirtualAPI(Application_Model_Ingredient $ingredient):                public void
	
	public function populateVirtualAPI(Application_Model_Ingredient $ingredient) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$recipe_count = $db->fetchOne('select count(id) as recipe_count from recipe_items where ingredient_id=?', $ingredient->getIngredientID());
		$ingredient->setRecipeCount($recipe_count);	
	}

    // }}}
	
    // Standard Mapper API
    // {{{ getDbTable():                                                                public Application_Model_DbTable_Ingredient 
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Ingredient();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ fromDbObject(Application_Model_Ingredient $ingredient, $data):               public void 

	public function fromDbObject(Application_Model_Ingredient $ingredient, $data) {
		$this->fromDbArray($ingredient, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_Ingredient $ingredient, array $data):          public void 
	
	public function fromDbArray(Application_Model_Ingredient $ingredient, array $data) {
		$ingredient->setIngredientID($data['id'])
				->setName($data['name'])
				->setDescription($data['description']);
	}

    // }}}
    // {{{ toDbArray(Application_Model_Ingredient $ingredient):                         public array 
	
	public function toDbArray(Application_Model_Ingredient $ingredient) {
	    $name = trim($ingredient->getName());
        if(empty($name)) {
            throw new RuntimeException('You cannot save an ingredient with an empty name.  Something went wrong somewhere.');
        }	
        
        $data = array(
			'name'=>$ingredient->getName(),
			'description'=>$ingredient->getDescription()
		);
		return $data;
	}

    // }}}
}

?>
