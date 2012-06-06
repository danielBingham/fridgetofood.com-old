<?php
abstract class Application_Service_Paginator_Adapter_Recipe_Abstract 
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Recipe $recipe, array $row) {
		$mapper = new Application_Model_Mapper_Recipe();
		$mapper->fromDbArray($recipe, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$recipes = array();
		foreach($rows as $row) {
			$recipe = new Application_Model_Recipe();
			$this->mapItem($recipe, $row);
			$recipes[] = $recipe;
		}
		return $recipes;
		
	}
}

?>