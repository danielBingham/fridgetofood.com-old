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

class SwaleORM_Mapper_Base {
    protected $_dbTable;
    protected $_modelName;
    protected $_fields;
	protected $_factory;
    protected $_config = array();

	/**
	
	*/
    public function __construct($modelName, SwaleORM_Factory $factory, array $config=array()) {
		$this->_factory = $factory;
        if(!isset($modelName)) {
            throw new BadMethodCallException('Definition parameter "modelName" is a required parameter.');
        } else {
            $modelClass = $this->_factory->getModelClass($modelName);
            if(!class_exists($modelClass)) {
                throw new InvalidArgumentException('"modelName" must be a valid model class in application/models.'); 
            }
            $this->_modelName = $modelName;
            $this->_fields = $modelClass::$_fields;
        }

        if(isset($config['db']) && !empty($config['db'])) {
            if(!($config['db'] instanceof Zend_Db_Adapter_Abstract)) {
                throw new InvalidArgumentException('Config parameter "db" must be an instance of Zend_Db_Adapter_Abstract.');
            } else {
                $this->_config['db'] = $config['db'];
            } 
        } else {
            $this->_config['db'] = null;
        }
    }

	/**

	*/
    public function nameFromDb($name) {
        return $name;
    }

	/**

	*/
    public function nameToDb($name) {
        return $name;
    }

	/**

	*/	
	public function fromDbObject($model, $data) {
		$this->fromDbArray($model, $data->toArray());
	}

	/**

	*/	
	public function fromDbArray($model, array $data) {
        $data = array_map('stripslashes', $data);
        foreach($this->_fields as $field=>$info) {
            if(isset($info['mapper'])) {
               	$mapper = $this->_factory->getFieldMapper($info['mapper']); 
                $model->$field = $mapper->fromDb($data[$this->nameToDb($field)]); 
            } else {
                $model->$field = $data[$this->nameToDb($field)];
            }  
        }       
    }

	/**

	*/
    public function toDbArray($model) {
        $data = array();
        foreach($this->_fields as $field=>$info) {
            if(isset($info['mapper'])) {
				$mapper = $this->_factory->getFieldMapper($info['mapper']);
                $data[$this->nameFromDb($field)] = $mapper->toDb($model->$field);
            } else {
                $data[$this->nameFromDb($field)] = $model->$field;
            }
        }
        return $data;
	}
    
}

?>
