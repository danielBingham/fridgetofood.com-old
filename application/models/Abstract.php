<?php
abstract class Application_Model_Abstract {
	
	private $_builder;
	private $_lazy;

	public abstract function ensureSafeLoad();
	
	protected function loadLazy() {
		return $this->_lazy;
	}
	
	protected function allowLazyLoad() {
		$this->_lazy = true;
	}
	
	protected function getBuilder() {
		return $this->_builder;
	}
	
	protected function setBuilder(Application_Model_Builder_Abstract $builder) {
		$this->_builder = $builder;
		return $this;
	}
		
		
	
	
}

?>
