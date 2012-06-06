<?php
class Application_Service_Paginator_Adapter_Farm_OfferingProduct
	extends Application_Service_Paginator_Adapter_Farm_Abstract {

		
	public function __construct(Application_Model_Ingredient $ingredient, $order='newest') {
		$select = Zend_Db_Table::getDefaultAdapter()
					->select()
					->from(array('farms'))
					->where('id in (select farm_id from farm_products where ingredient_id=?)', $ingredient->getIngredientID());
		
		switch($order) {
			case 'newest':
				$select->order('created desc');
				break;
			default:
				$select->order('created asc');
				break;
		}
		
		parent::__construct($select);
	}
		
}
?>	