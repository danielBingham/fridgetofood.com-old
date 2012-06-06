<?php
abstract class Application_Service_Paginator_Adapter_User_Abstract
	extends Zend_Paginator_Adapter_DbSelect {
		
		
	protected function mapItem(Application_Model_User $user, array $row) {
		$mapper = new Application_Model_Mapper_User();
		$mapper->fromDbArray($user, $row);
	}
	
	public function getItems($offset, $itemCountPerPage) {
		$rows = parent::getItems($offset, $itemCountPerPage);
		
		$users = array();
		foreach($rows as $row) {
			$user = new Application_Model_User();
			$this->mapItem($user, $row);
			$users[] = $user;
		}
		return $users;
		
	}	
		
}

?>