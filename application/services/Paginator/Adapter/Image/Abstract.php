<?php
abstract class Application_Service_Paginator_Adapter_Image_Abstract
	extends Zend_Paginator_Adapter_DbSelect {
	
	protected function mapItem(Application_Model_Image $image, array $row) {
		$mapper = new Application_Model_Mapper_Image();
		$mapper->fromDbArray($image, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);

		$images = array();
		foreach($rows as $row) {
			$image = new Application_Model_Image();
			$this->mapItem($image, $row);
			$images[] = $image;
		}
		return $images;
		
	}
	
}
?>