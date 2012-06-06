<?php
class Application_Service_Paginator_Adapter_Ingredient_All
	extends Application_Service_Paginator_Adapter_Ingredient_Abstract {
		
	public function __construct() {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('ingredients'),
			array(
				'*',
				'recipe_count'=> '(select count(id) from recipe_items where ingredient_id=ingredients.id) as recipe_count'
			)
		);
		$select->where('(select count(id) from recipe_items where ingredient_id=ingredients.id) > 0');
		$select->order('recipe_count desc');
		
		parent::__construct($select);
	}
	
		
}

?>