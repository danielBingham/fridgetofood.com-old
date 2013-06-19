<?php
class Application_Model_Persistor_Farm {
	
	private $_mapper;
	
	protected function getMapper() {
		if(empty($this->_mapper)) {
			$this->_mapper = new Application_Model_Mapper_Farm();
		}
		return $this->_mapper;
	}
	
	public function create(Application_Model_Farm $farm) {
		$this->insert($farm);
	}
	
	public function save(Application_Model_Farm $farm) {
		if($farm->getFarmID()) {
			$this->update($farm);
		} else {
			$this->insert($farm);
		}
	}
	
	protected function insert(Application_Model_Farm $farm) {
		$farm->setCreated(Zend_Date::now());
		$farm->setModified(Zend_Date::now());
		
		$data = $this->getMapper()->toDbArray($farm);
		$this->getMapper()->getDbTable()->insert($data);
	}
	
	protected function update(Application_Model_Farm $farm) {
		$farm->setModified(Zend_Date::now());
		
		$data = $this->getMapper()->toDbArray($farm);
		$this->getMapper()->getDbTable()->update($data, array('id=?'=>$farm->getFarmID()));		
	}
	
}
?>
