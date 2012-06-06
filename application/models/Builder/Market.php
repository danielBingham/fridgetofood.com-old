<?php
class Application_Model_Builder_Market extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'farms'=>false,
			'user'=>false	
		);
	}
	
	protected function buildFarms(Application_Model_Market $market) {
		$market->setFarms(Application_Model_Query_Farm::getInstance()->getFarmsForMarket($market));
	}
	
	protected function buildUser(Application_Model_Market $market) {
		$market->setUser(Application_Model_User::getInstance()->get($market->getUserID()));		
	}

	public function buildAll(Application_Model_Market $market) {
		$this->buildFarms($market);
		$this->buildUser($market);
	}
}