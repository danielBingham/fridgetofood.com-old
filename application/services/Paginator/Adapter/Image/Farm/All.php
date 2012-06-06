<?php
class Application_Service_Paginator_Adapter_Image_Farm_All
	extends Application_Service_Paginator_Adapter_Image_Abstract {

	public function __construct($order='newest ') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('images'),
			array(
				'*',
			)
		);
		$select->where('id in (select image_id as id from farm_images)');
		
		switch($order) {
			case 'newest':
				$select->order('created desc')->order('views asc');
				break;
			default:
				$select->order('created desc');
				break;
		}
		
		parent::__construct($select);
	}
		
}
	
?>