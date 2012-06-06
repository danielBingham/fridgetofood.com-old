<?php
abstract class Application_Service_Paginator_Adapter_Market_Abstract 
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Market $market, array $row) {
		$mapper = new Application_Model_Mapper_Market();
		$mapper->fromDbArray($market, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$markets = array();
		foreach($rows as $row) {
			$market = new Application_Model_Market();
			$this->mapItem($market, $row);
			$markets[] = $market;
		}
		return $markets;
		
	}
}

?>