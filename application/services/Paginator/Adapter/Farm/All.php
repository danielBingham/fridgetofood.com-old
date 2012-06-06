<?php
class Application_Service_Paginator_Adapter_Farm_All 
	extends Application_Service_Paginator_Adapter_Farm_Abstract {

		
	public function __construct($order='newest') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(array('farms'));
		
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