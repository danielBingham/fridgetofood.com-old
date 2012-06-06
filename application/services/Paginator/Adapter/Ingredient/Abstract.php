<?php
abstract class Application_Service_Paginator_Adapter_Ingredient_Abstract
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Ingredient $ingredient, array $row) {
		$mapper = new Application_Model_Mapper_Ingredient();
		$mapper->fromDbArray($ingredient, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$ingredients = array();
		foreach($rows as $row) {
			$ingredient = new Application_Model_Ingredient();
			$this->mapItem($ingredient, $row);
			$ingredients[] = $ingredient;
		}
		return $ingredients;
		
	}
		
		
}

?>