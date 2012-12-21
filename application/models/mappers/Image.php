<?php
class Application_Model_Mapper_Image extends Application_Model_Mapper_Base {
	
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
}
