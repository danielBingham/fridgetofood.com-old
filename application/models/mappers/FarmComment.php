<?php
class Application_Model_Mapper_FarmComment {

	private $_dbTable;
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_FarmComment();
		}
		return $this->_dbTable;
	}	
	
	public function fromDbObject(Application_Model_FarmComment $farmComment, $data) {
		$this->fromDbArray($farmComment, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_FarmComment $farmComment, array $data) {
		$farmComment->setFarmCommentID($$data['id'])
					->setUserID($data['user_id'])
					->setFarmID($data['farm_id'])
					->setContent($data['content'])
					->setCreated($data['created'])
					->setModified($data['modified']);

	}
	
	public function toDbArray(Application_Model_FarmComment $farmComment) {
		$data = array(
			'user_id'=>$farmComment->getUserID(),
			'farm_id'=>$farmComment->getFarmID(),
			'content'=>$farmComment->getContent(),
			'created'=>$farmComment->getCreated()->toString('yyyy-MM-dd HH:mm:ss'),
			'modified'=>$farmComment->getModified()->toString('yyyy-MM-dd HH:mm:ss')
		);
		return $data;
	}
}
?>