<?php
class Application_Model_Mapper_Image {
	private $_dbTable;
	
	public function populateVirtualAPI(Application_Model_Image $image) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$votes = $db->fetchOne('select coalesce(sum(image_votes.vote), 0) as votes from image_votes where image_id=?', $image->getImageID());
		$image->setVotes($votes);	
	}

    public function vote(Application_Model_User $user, Application_Model_Image $image, $vote) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = 'INSERT INTO image_votes (image_id, user_id, vote)
                    VALUES (' . $db->quoteInto('?', $image->getImageID()) . ', '
                            . $db->quoteInto('?', $user->getUserID()) . ', '
                            . $db->quoteInto('?', $vote) . ')';

        $db->query($sql);
    }
	
	/****************************************************************************
	 * Standard Mapper API
	 ****************************************************************************/
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_Image();
		}
		return $this->_dbTable;
	}
	
	public function fromDbObject(Application_Model_Image $image, $data) {
		$this->fromDbArray($image, $data->toArray());
	}
	
	public function fromDbArray(Application_Model_Image $image, array $data) {
		$image->setImageID($data['id'])
			->setUserID($data['user_id'])
			->setWidth($data['width'])
			->setHeight($data['height'])
			->setViews($data['views'])
			->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
			->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601));
	}
	
	
	public function toDbArray(Application_Model_Image $image) {
		$data = array(
			'user_id'=>$image->getUserID(),
			'width'=>$image->getWidth(),
			'height'=>$image->getHeight(),
			'views'=>$image->getViews(),
			'created'=>$image->getCreated()->toString('yyyy-MM-dd HH:mm:ss'),
			'modified'=>$image->getModified()->toString('yyyy-MM-dd HH:mm:ss')
		);
		return $data;
	}
}

?>
