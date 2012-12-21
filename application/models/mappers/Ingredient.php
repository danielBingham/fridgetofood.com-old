<?php
class Application_Model_Mapper_Ingredient extends Application_Model_Mapper_Base {
	
    // {{{ populateVirtualAPI(Application_Model_Ingredient $ingredient):                public void
	
	public function populateVirtualAPI(Application_Model_Ingredient $ingredient) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$recipe_count = $db->fetchOne('select count(id) as recipe_count from recipe_items where ingredient_id=?', $ingredient->getIngredientID());
		$ingredient->setRecipeCount($recipe_count);	
	}

    // }}}
	
}
