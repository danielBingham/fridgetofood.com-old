<?php
class Application_Service_Paginator_Adapter_Tag_Farm_All
	extends Application_Service_Paginator_Adapter_Tag_Abstract {
		
	public function __construct() {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('tags'),
			array(
				'*',
				'farm_count'=> '(select count(id) from farm_tags where tag_id=tags.id) as farm_count'
			)
		);
		$select->where('(select count(id) from farm_tags where tag_id=tags.id) > 0')
				->where('site=?', 'farm');
		$select->order('farm_count desc');
		
		parent::__construct($select);
	}
		
		
		
}