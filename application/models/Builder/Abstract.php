<?php
class Application_Model_Builder_Abstract {
	
	protected $_haveBuilt;
	
	public function build($association, $model) {
		if(!array_key_exists($association, $this->_haveBuilt)) {
			throw new Exception('Attempt to build non-existent association "' . $association . '"');
		}
		
		$model->ensureSafeLoad();
		
		if($this->_haveBuilt[$association]) {
			return;
		}

		$this->_haveBuilt[$association] = true;
		
		$method = 'build' . ucfirst($association);
		$this->$method($model);
	}
	
	
}
?>