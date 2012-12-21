<?php
class Application_Model_Mapper_Tag extends Application_Model_Mapper_Base {

    // {{{ getRecipeCount(Application_Model_Tag $tag)
	
	public function determineRecipeCount(Application_Model_Tag $tag) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchAll('select count(id) as recipe_count from recipe_tags where tag_id=?', $tag->getTagID());

		if(!empty($results)) {
			$tag->setRecipeCount($results[0]['recipe_count']);
		} else {
			$tag->setRecipeCount(0);
		}
	}

    // }}}
    // {{{ fromDbArray(Application_Model_Tag $tag, array $data) 
	
	public function fromDbArray(Application_Model_Tag $tag, array $data) {
        parent::fromDbArray($tag, $data);
        $tag->created = new Zend_Date($tag->created, Zend_Date::ISO_8601);
        $tag->modified = new Zend_Date($tag->modified, Zend_Date::ISO_8601);
	}

    // }}}
    // {{{ toDbArray(Application_Model_Tag $tag)
	
	public function toDbArray(Application_Model_Tag $tag) {
        $data = parent::toDbArray($tag);
        $data['created'] = ($data['created'] ? $data['created']->toString('yyyy-MM-dd HH:mm:ss') : '');
        $data['modified'] = ($data['modified'] ? $data['modified']->toString('yyyy-MM-dd HH:mm:ss') : ''); 
		return $data;
	}

    // }}}	
}

?>
