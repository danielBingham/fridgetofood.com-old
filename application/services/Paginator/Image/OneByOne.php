<?php
class Application_Service_Paginator_Image_OneByOne 
	extends Application_Service_Paginator {
		
		public function __construct(Zend_Paginator_Adapter_DbSelect $adapter) {
			parent::__construct($adapter);
			$this->setItemCountPerPage(1);
		}

		public function getPageForItem(Application_Model_Image $image) {
			for($page = 1; $page <= $this->getPages()->pageCount; $page++) {
				$item = $this->getItemsByPage($page);
				if($item[0]->getImageID() == $image->getImageID()) {
					return $page;
				}
			}
			return NULL;
		}
		
		public function getNextItem() {			
			if($this->getCurrentPageNumber() == $this->getPages()->pageCount) {
				return NULL;
			}
			
			$items = $this->getItemsByPage($this->getCurrentPageNumber()+1);
			return $items[0];
		}
		
		public function getPrevItem() {
			if($this->getCurrentPageNumber() == 1) {
				return NULL;
			}
			
			$items = $this->getItemsByPage($this->getCurrentPageNUmber()-1);
			return $items[0];
		}
		
}

?>