<?php
class Application_Service_Paginator_Adapter_Farm_TaggedWith
	extends Application_Service_Paginator_Adapter_Farm_Abstract {
		
	public function __construct(Application_Model_Tag $tag, $order='newest') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('farms'),
			array(
				'*',
			)
		)->where('id in (select farm_id from farm_tags where tag_id=?)', $tag->getTagID());
		
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