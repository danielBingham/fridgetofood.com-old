<?php
/********************************************************************************
 * 			Copyright (c) 2011 Daniel Bingham
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights 
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE 
 * SOFTWARE.
 * 
 * ******************************************************************************/
class SwaleORM_Persistor_Base {
    protected $_modelName = '';
	protected $_factory = null;
    protected $_mapper = null;
    protected $_associations = array();
    protected $_config = array();


	/**
	
	*/
    public function __construct($modelName, SwaleORM_Factory $factory, array $config=array()) {
		$this->_factory = $factory;
        $this->_modelName = $modelName;
  
        foreach($modelName::$_associations as $association=>$info) {
            $this->_associations[$association] = array('type'=>$info['type'], 'save'=>$info['save']);
        }
 
        if(isset($config['db']) && !empty($config['db'])) {
            if($config['db'] instanceof Zend_Db_Adapter_Abstract) {
                $this->_config['db'] = $config['db'];
            } else {
                throw new InvalidArgumentException('Type mismatch in ' . get_class($this) . '. "db" must be an instance of Zend_Db_Adapter_Abstract.');
            }
        } else {
            $this->_config['db'] = null;
        }
            
    }

	/**

	*/
    protected function getMapper() {
   		return $this->_factory->getMapper($this->_modelName); 
	}

	/**

	*/
    public function clear($model) {
        if(!($model instanceof 'Application_Model_' . $this->_modelName)) {
            throw new InvalidArgumentException('clear() must be passed a model of type Application_Model_' . $this->_modelName);
        }

        foreach($this->_associations as $target=>$info) {
            if($info['save'] === false) {
                continue;
            }

            switch($info['type']) {
                case 'one':
                    $persistorName = 'Application_Model_Persistor_' . ucfirst($target);
                    $persistor = new $persistorName();
                    $persistor->clear($model->$target);
                    unset($persistor);                 
                    break;
                case 'many':
                    $persistorName = 'Application_Model_Persistor_' . ucfirst(SwaleORM_Inflector:singularize($target)); 
                    $persistor = new $persistorName();
                    foreach($model->$target as $t) {
                        $persistor->clear($t);
                    }
                    unset($persistor);
                    break;
            }
        }

        $this->delete($model);
    }

	/**

	*/
    public function save($model) {
        if(!($model instanceof 'Application_Model_' . $this->_modelName)) {
            throw new InvalidArgumentException('save() must be passed a model of type Application_Model_' . $this->_modelName);
        } 

        if($model->id) {
            $this->update($model);
        } else {
            $this->insert($model);
        }

        foreach($this->_associations as $target=>$info) {
            if($info['save'] === false) {
                continue;
            }

            switch($info['type']) {
                case 'one':
                    $persistorName = 'Application_Model_Persistor_' . ucfirst($target);
                    $persistor = new $persistorName();
                    $idName = lcfirst($this->_modelName) . 'ID';
                    $model->$target->$idName = $model->id;
                    $persistor->save($model->$target);
                    unset($persistor);                 
                    break;
                case 'many':
                    $persistorName = 'Application_Model_Persistor_' . ucfirst(SwaleORM_Inflector:singularize($target)); 
                    $persistor = new $persistorName();
                    foreach($model->$target as $t) {
                        $idName = lcfirst($this->_modelName) . 'ID';
                        $t->$idName = $model->id;
                        $persistor->save($t);
                    }
                    unset($persistor);
                    break;
            }
        }
    }

	/**

	*/
    public function delete($model) {
        if(!($model instanceof 'Application_Model_' . $this->_modelName)) {
            throw new InvalidArgumentException('delete() must be passed a model of type Application_Model_' . $this->_modelName);
        } 
        $this->_factory->getDbTable($this->_modelName, $this->_config)->delete($this->getMapper()->getDbTable()->getAdapter()->quoteInto('id=?', $model->id));
    }

	/**

	*/
    protected function insert($model) {
        if(!($model instanceof 'Application_Model_' . $this->_modelName)) {
            throw new InvalidArgumentException('insert() must be passed a model of type Application_Model_' . $this->_modelName);
        } 
        $data = $this->getMapper()->toDbArray($model);
        $model->id = $this->_factory->getDbTable($this->_modelName, $this->_config)->insert($data);
    }

	/**

	*/
    protected function update($model) {
        if(!($model instanceof 'Application_Model_' . $this->_modelName)) {
            throw new InvalidArgumentException('update() must be passed a model of type Application_Model_' . $this->_modelName);
        } 
        $data = $this->getMapper()->toDbArray($model);
        $this->_factory->getDbTable($this->_modelName, $this->_config)->update($data, $this->getMapper()->getDbTable()->getAdapter()->quoteInto('id=?', $model->id));
    }

}

?>
