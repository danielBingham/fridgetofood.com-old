<?php
/**
*
*/
class Application_Model_Mapper_RecipeComment extends Application_Model_Mapper_Base {


    // {{{ fromDbArray(Application_Model_RecipeComment $recipeComment, array $data):                public void
	
	public function fromDbArray(Application_Model_RecipeComment $recipeComment, array $data) {
        parent::__fromDbArray($recipeComment, $data);
        $recipeComment->created = new Zend_Date($data['created'], Zend_Date::ISO_8601);
        $recipeComment->modified = new Zend_Date($data['modified'], Zend_Date::ISO_8601);
	}

    // }}}
    // {{{ toDbArray(Application_Model_RecipeComment $recipeComment):                               public array(mixed)
	
	public function toDbArray(Application_Model_RecipeComment $recipeComment) {
		$data = parent::_toDbArray($recipeComment);
        $data['created'] = ($data['created'] instanceof Zend_Date ? $data['created']->toString('yyyy-MM-dd HH:mm:ss') : '');
        $data['modified'] = ($data['modified'] instanceof Zend_Date ? $data['modified']->toString('yyyy-MM-dd HH:mm:ss') : '');

		return $data;
	}

    // }}}

}
?>
