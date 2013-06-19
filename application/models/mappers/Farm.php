<?php
class Application_Model_Mapper_Farm {
	
	protected $_dbTable;
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Farm();
		}
		return $this->_dbTable;
	}
	
	public function fromDbObject(Application_Model_Farm $farm, $data) {
		$this->fromDbArray($farm, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_Farm $farm, array $data) {
		$farm->setFarmID($data['id'])
			->setName($data['name'])
			->setDescription($data['description'])
			->setWebsite($data['website'])
			->setEmail($data['email'])
			->setPhone($data['phone'])
			->setAddress($data['address'])
			->setOpenTimes($data['open_times'])
			->setUserID($data['user_id'])
			->setViews($data['views'])
			->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
			->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601));
	}
	
	public function toDbArray(Application_Model_Farm $farm) {
		$data = array(
			'name'=>$farm->getName(),
			'description'=>$farm->getDescription(),
		    'website'=>$farm->getWebsite(),
			'email'=>$farm->getEmail(),
			'phone'=>$farm->getPhone(),
			'address'=>$farm->getAddress(),
			'open_times'=>$farm->getOpenTimes(),
			'user_id'=>$farm->getUserID(),
			'views'=>$farm->getViews(),
			'created'=>$farm->getCreated()->toString('yyyy-MM-dd HH:mm:ss'),
			'modified'=>$farm->getModified()->toString('yyyy-MM-dd HH:mm:ss')
		);
		return $data;
	}
	
}
?>