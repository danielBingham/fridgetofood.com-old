<?php
class Application_Service_Paginator_Adapter_Market_All 
	extends Application_Service_Paginator_Adapter_Market_Abstract {

		
	public function __construct($order='newest') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(array('markets'));
		
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