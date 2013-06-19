<?php
class Application_Model_Mapper_Tag {
	private $_dbTable;
	
	
	public function getRecipeCount(Application_Model_Tag $tag) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchAll('select count(id) as recipe_count from recipe_tags where tag_id=?', $tag->getTagID());

		if(!empty($results)) {
			$tag->setRecipeCount($results[0]['recipe_count']);
		} else {
			$tag->setRecipeCount(0);
		}
	}
	
	
	/****************************************************************************
	 * Standard Mapper API
	 ****************************************************************************/
	
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Tag();
		}
		return $this->_dbTable;
	}

	public function fromDbObject(Application_Model_Tag $tag, $data) {
		$this->fromDbArray($tag, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_Tag $tag, array $data) {
		$tag->setTagID($data['id'])
				->setName($data['name'])
				->setType($data['type'])
				->setDescription($data['description'])
				->setRevision($data['revision'])
				->setUserID($data['user_id'])
				->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
				->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601));
		
	}
	
	public function toDbArray(Application_Model_Tag $tag) {
		$data = array(
			'name'=>$tag->getName(),
			'type'=>$tag->getType(),
			'description'=>$tag->getDescription(),
			'revision'=>$tag->getRevision(),
			'user_id'=>$tag->getUserID(),
			'created'=>($tag->getCreated() ? $tag->getCreated()->toString('yyyy-MM-dd HH:mm:ss') : null),
			'modified'=>($tag->getModified() ? $tag->getModified()->toString('yyyy-MM-dd HH:mm:ss') : null),
		);
		return $data;
	}
	
}

?>
