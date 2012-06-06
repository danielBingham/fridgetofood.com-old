<?php
class Application_Model_Mapper_Market {
	
	private $_dbTable;
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Market();
		}
		return $this->_dbTable;
	}
	
	public function fromDbObject(Application_Model_Market $market, $data) {
		$this->fromDbArray($market, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_Market $market, array $data) {
		$market->setMarketID($data['id'])
				->setName($data['name'])
				->setDescription($data['description'])
				->setAddress($data['address'])
				->setEmail($data['email'])
				->setWebsite($data['website'])
				->setOpenTimes($data['open_times'])
				->setStartDate(new Zend_Date($data['start_date'], Zend_Date::ISO_8601))
				->setEndDate(new Zend_Date($data['end_date'], Zend_Date::ISO_8601))
				->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
				->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601))
				->setUserID($data['user_id']);
	}
	
	public function toDbArray(Application_Model_Market $market) {
		$data = array(
			'name'=>$market->getName(),
			'description'=>$market->getDescription(),
			'address'=>$market->getAddress(),
			'email'=>$market->getEmail(),
			'website'=>$market->getWebsite(),
			'open_times'=>$market->getOpenTimes(),
			'start_date'=>$market->getStartDate()->toString('yyyy-MM-dd HH:mm:ss'),
			'end_date'=>$market->getEndDate()->toString('yyyy-MM-dd HH:mm:ss'),
			'created'=>$market->getCreated()->toString('yyyy-MM-dd HH:mm:ss'),
			'modified'=>$market->getModified()->toString('yyyy-MM-dd HH:mm:ss'),
			'user_id'=>$market->getUserID()
		);
		return $data;
	}
	
}
?>