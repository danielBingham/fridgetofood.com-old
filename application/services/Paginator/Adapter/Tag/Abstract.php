<?php
abstract class Application_Service_Paginator_Adapter_Tag_Abstract
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Tag $tag, array $row) {
		$mapper = new Application_Model_Mapper_Tag();
		$mapper->fromDbArray($tag, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$tags = array();
		foreach($rows as $row) {
			$tag = new Application_Model_Tag();
			$this->mapItem($tag, $row);
			$tags[] = $tag;
		}
		return $tags;
		
	}
	
	
}
?>