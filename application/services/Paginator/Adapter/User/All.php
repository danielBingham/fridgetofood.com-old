<?php
class Application_Service_Paginator_Adapter_User_All
	extends Application_Service_Paginator_Adapter_User_Abstract {
		
		
	public function __construct($order) {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('users'),
			array(
				'*',
				'recipe_count'=> '(select count(id) from recipes where user_id=users.id) as recipe_count'
			)
		);
		
		switch($order) {
			case 'newest':
				$select->order('created desc');
				break;
			case 'reputation':
				$select->order('reputation desc');
				break;
			case 'active':
				$select->order('seen desc');
				break;
			case 'recipes':
				$select->order('recipe_count desc');
				break;
			default:
				$select->order('reputation desc');
				break;
		}

		
		parent::__construct($select);
	}
		
		
}


?>
