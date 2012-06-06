<?php
abstract class Application_Service_Paginator_Adapter_Farm_Abstract 
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Farm $farm, array $row) {
		$mapper = new Application_Model_Mapper_Farm();
		$mapper->fromDbArray($farm, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$farms = array();
		foreach($rows as $row) {
			$farm = new Application_Model_Farm();
			$this->mapItem($farm, $row);
			$farms[] = $farm;
		}
		return $farms;
		
	}
}

?>