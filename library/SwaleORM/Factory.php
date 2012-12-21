<?PHP

class SwaleORM_Factory {
	private $_queries = array();
	private $_persistors = array();
	private $_mappers = array();
	private $_dbTables = array();

	/**

	*/
	public function __construct() {

	}

	/**

	*/
	public function getQuery($modelName, array $config=array()) {
		if( ! isset($this->_queries[$modelName])) {
			$className = 'Application_Model_Query_' . $modelName;
			if(class_exists($className)) {
				$this->_queries[$modelName] = new $className($this, $config);
			} else if(class_exists('Application_Model_Query_Base')) {
				$this->_queries[$modelName] = new Application_Model_Query_Base($modelName, $this, $config);
			} else {
				$this->_queries[$modelName] = new SwaleORM_Query_Base($modelName, $config);
			} 
		}
		return $this->_queries[$modelName];
	}

	/**

	*/
	public function getPersistor($modelName, array $config=array()) {
		if( ! isset($this->_persistors[$modelName])) {
			$className = 'Application_Model_Persistor_' . $modelName;
			if(class_exists($className)) {
				$this->_persistors[$modelName] = new $className($this, $config);
			} else if(class_exists('Application_Model_Persistor_Base')) {
				$this->_persistors[$modelName] = new Application_Model_Persistor_Base($modelName, $this, $config);
			} else {
				$this->_persistors[$modelName] = new SwaleORM_Persistor_Base($modelName, $config);
			} 
		}
		return $this->_persistors[$modelName];
	}

	/**

	*/
	public function getBuilder($modelName, array $config=array()) {
		$className = 'Application_Model_Builder_' . $modelName;
		if(class_exists($className)) {
			return new $className($this, $config);
		} else if(class_exists('Application_Model_Builder_Base')) {
			return new Application_Model_Builder_Base($modelName, $this, $config);
		} 
		return new SwaleORM_Builder_Base($modelName, $this, $config);
	}

	/**

	*/
	public function getMapper($modelName, array $config=array()) {
		if( ! isset($this->_mappers[$modelName])) {
			$className = 'Application_Model_Mapper_' . $modelName;
			if(class_exists($className)) {
				$this->_mappers[$modelName] = new $className($this, $config);
			} else if(class_exists('Application_Model_Mapper_Base')) {
				$this->_mappers[$modelName] = new Application_Model_Mapper_Base($modelName, $this, $config);
			} else {
				$this->_mappers[$modelName] = new SwaleORM_Mapper_Base($modelName, $config);
			} 
		}
		return $this->_mappers[$modelName];
	}

	/**

	*/
	public function getModel($modelName, array $config=array()) {
		$className = 'Application_Model_' . $modelName;
		$object = new $className($config);
		return $object;
	}

	/**

	*/
	public function getModelClass($modelName) {
		return 'Application_Model_' . $modelName;
	}

	/**

	*/
	public function getDbTable($modelName, array $config=array()) {
		if(!isset($this->_dbTables[$modelName])) {
            $tableName = 'Application_Model_DbTable_' . $modelName;
            if(isset($config['db']) && $config['db'] !== null) {
                $this->_dbTables[$modelname] = new $tableName(array('db'=>$config['db']));
            } else {
                $this->_dbTables[$modelName] = new $tableName();
            }
		}
		return $this->_dbTables[$modelName];
	}


	/**

	*/
	public function getFieldMapper($mapperName) {
        if(class_exists('Application_Model_Mapper_Field_' . $mapperName)) {
            $mapperClass = 'Application_Model_Mapper_Field_' . $mapperName;
            return new $mapperClass();
        } else if(class_exists('SwaleORM_Mapper_Field_' . $mapperName)) {
            $mapperClass = 'SwaleORM_Mapper_Field_' . $mapperName;
            return new $mapperClass();
        } else {
            throw new InvalidArgumentException('Field mapper "' . $mapperName . '" not found!'); 
        }
	}
}

?>
