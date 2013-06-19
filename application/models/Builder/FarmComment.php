<?php
class Application_Model_Builder_FarmComment extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'user'=>false
		);
	}
	
	protected function buildUser(Application_Model_FarmComment $farmComment) {
		$farmComment->setUser(Application_Model_Query_User::getInstance()->get($farmComment->getUserID()));
	}
	
	public function buildAll(Application_Model_FarmComment $farmComment) {
		$this->build('user', $farmComment);
	}
	
}

?>