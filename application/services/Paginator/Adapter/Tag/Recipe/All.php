<?php
class Application_Service_Paginator_Adapter_Tag_Recipe_All
	extends Application_Service_Paginator_Adapter_Tag_Abstract {
		
	public function __construct($type='all') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('tags'),
			array(
				'*',
				'recipe_count'=> '(select count(id) from recipe_tags where tag_id=tags.id) as recipe_count'
			)
		);
		$select->where('(select count(id) from recipe_tags where tag_id=tags.id) > 0');
        if($type != 'all') {
            $select->where('type=?', $type);
        }
		$select->order('recipe_count desc');
		
		parent::__construct($select);
	}
		
		
		
}
?>
