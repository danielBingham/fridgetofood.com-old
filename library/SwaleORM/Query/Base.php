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
class SwaleORM_Query_Base {
    protected static $_instances = array();
	
	private $_factory = null;
    private $_modelName = null;
    private $_mapper = null;
    private $_builder = null;

    private $_config = array();

	/**

	*/    
    public function __construct($modelName, SwaleORM_Factory $factory, array $config=array()) { 
        if(!isset($modelName)) {
            throw new BadMethodCallException('"modelName" is a required parameter in ' . get_class($this));
        }
        $this->_modelName = $modelName;
		$this->_factory = $factory;
		
        if(isset($config['db']) && !empty($config['db'])) {
            if($config['db'] instanceof Zend_Db_Adapter_Abstract) {
                $this->_config['db'] = $config['db'];
            } else {
                throw new InvalidArgumentException('Type mismatch in ' . get_class($this) . '.  "db" must be an instance of Zend_Db_Adapter_Abstract.');
            }
        } else {
            $this->_config['db'] = null;
        }
    }
    


	/**

	*/
    public function getMapper() {
        return $this->_factory->getMapper($this->_modelName, $this->_config); 
    }

	/**

	*/
    public function getBuilder() {
        return $this->_factory->getBuilder($this->_modelName, $this->_config);
    }

	/**

	*/
    public function getModel() {
        return $this->_factory->getModel($this->_modelName, $this->_config);
    }


    public function getDb() {
        if($this->_config['db'] !== null) {
            return $this->_config['db'];
        } else {
            return Zend_Db_Table::getDefaultAdapter();
        }
    }

    /**
        Takes a parameterized SQL query and an optional array of parameters
        and quotes the parameters into the query.  Either ? or :key can be
        used and they can mixed together.  :key style parameters will be
        replaced first (as long as there is a match key=>value pair in the 
        parameters array) and then any '?' parameters will be replaced by
        the remaining parameters, in order.  An optional enum ($return) may
        be used to specify whether your query will return a set of IDs of
        this model, a set of rows complaining complete model data for this
        model or neither.  In the case of the first two, query will 
        use the returned data to populate a set of models and will return
        an array of model objects.  In the case of the last one, the raw
        result of the query will be returned. 

        @param string $sql The SQL query to be parameterized.
        @param array $parameters The array of parameters to be quoted an placed in the SQL.
        @param ENUM('model', 'id', 'neither') $return Specify the expected return of the query, default 'neither'.
        
        @return Raw result array | array of populated models depending on the $return parameter.
   */
    public function query($sql, $parameters=array(), $return='neither') {
        if(!empty($parameters)) {
            // First replace any named parameters.
            foreach($parameters as $key=>$value) {
                if(strpos($sql, ':'.$key) !== false) {
                    $sql = str_replace(':'.$key, $this->db->quote($value), $sql);
                    unset($parameters[$key]);
                }
            }

            foreach($parameters as $value) {
                $pos = strpos($sql, '?');
                if($pos !== false) {
                    $sql = substr_replace($sql, $this->db->quote($value), $pos, 1);
                }
            }
        }

        $result = $this->getDb()->fetchAll($sql);

        switch($return) {
            case 'neither':
                return $result;
            case 'id':
                $modelResults = array();
                foreach($result as $row) {
                    $modelResults[] = $this->get($row['id']);
                }
                return $modelResults;
            case 'model':
                $modelResults = array();
                foreach($results as $row) {
                    $modelResults[] = $this->getMapper()->fromDbArray($row);
                }
                return $modelResults;
            default:
                throw new DomainException('Invalid $return("' . $return . '") given to SwaleORM_Query_Abstract::query()'); 
        }
    }
	
	/**
	    Fetch an array of models that match the conditions provided.
        If none are found, return an empty array. 

        @param array $conditions The conditions to be matched.
        
        @return array(Application_Model_{$model}) An array of models that match the conditions, or an empty array.
	 */
	public function fetchAll(array $conditions=NULL) {
		
		if(!empty($conditions)) {
			$select = $this->getMapper()->getDbTable()->select();
			
			foreach($conditions as $field=>$value) {
				$select->where("$field=?", $value);	
			}
			$rows = $this->getMapper()->getDbTable()->fetchAll($select);
		} else {
			$rows = $this->getMapper()->getDbTable()->fetchAll();
		}
		
		if(count($rows) == 0) {
			return array();
		}
		
		$items = array();
		foreach($rows as $row) {
			$item = $this->getModel();
			$this->getMapper()->fromDbObject($item, $row);
			$items[] = $item;
		}
		return $items;		
	}

    /**
	    Fetch an array of all models matching a given array of conditions.
        If no conditions are given, then fetch all models.  Builds all 
        associations of the fetched models.  If none are found, return
        an empty array.

        @param array $conditions An array of conditions to be matched.
    
        @return array(Application_Model_{$model}) An array of models, with associations built. 
	 */
	public function fetchAllBuildAll(array $conditions=NULL) {
		if(!empty($conditions)) {
			$select = $this->getMapper()->getDbTable()->select();

			foreach($conditions as $field=>$value) {
				$select->where("$field=?", $value);	
			}

			$rows = $this->getMapper()->getDbTable()->fetchAll($select);
		} else {
			$rows = $this->getMapper()->getDbTable()->fetchAll();
		}
		
		if(count($rows) == 0) {
			return array();
		}
		
		$items = array();
		foreach($rows as $row) {
			$item = $this->getModel();
			$this->getMapper()->fromDbObject($item, $row);
			$this->getBuilder()->build('all', $item);
			$items[] = $item;
		}
		return $items;
	}
	
	/**
	    Find a single model that matches the given
 	    conditions.  If more than one model is matched or no models are
 	    matched, return NULL.  Do not load associations.
 	 
        @param array $conditions The array of conditions to be matched.
 
 	    @return Application_Model_{$model} A populated model with out associations or NULL.
	 */
	public function fetchOne(array $conditions) {
		$select = $this->getMapper()->getDbTable()->select();

		foreach($conditions as $field=>$value) {
			$select->where("$field=?", $value);	
		}

		$result = $this->getMapper()->getDbTable()->fetchAll($select);
	
        $count = count($result);
		if($count != 1) {
            if($count > 1) {
                throw new RangeException('Conditions passed to fetchOne() resulted in multiple results returned.');
            } else {
                throw new UnderflowException('Conditions passed to fetchOne() resulted in no results!');
            }	
        }
		
		$item = $this->getModel();
		$this->getMapper()->fromDbObject($item, $result->current());
		return $item;
	}
	
	/**
	    Find a single model that matches the given
	    conditions.  If more than one model is matched or no models
	    are matched, return NULL.
	 
        @param array $conditions The array of conditions to be matched.
 
	    @return Application_Model_{$model} A populated model with associations or NULL.
	 */
	public function fetchOneBuildAll(array $conditions) {
		$select = $this->getMapper()->getDbTable()->select();

		foreach($conditions as $field=>$value) {
			$select->where("$field=?", $value);	
		}

		$result = $this->getMapper()->getDbTable()->fetchAll($select);
		
        $count = count($result);
		if($count != 1) {
            if($count > 1) {
                throw new RangeException('Conditions passed to fetchOneBuildAll() resulted in multiple results returned.');
            } else {
                throw new UnderflowException('Conditions passed to fetchOneBuildAll() resulted in no results!');
            }	
        }
		
		$item = $this->getModel();
		$this->getMapper()->fromDbObject($item, $result->current());
		$this->getBuilder()->build('all', $item);
		return $item;
	}
	
	/**
	    Get a the item model for a given id from the database.
	    Populate the model, but do not retrieve associations.  Return
	    NULL if no model is found.
	 
        @param int $itemID The id of the model to be retrieved.
 
	    @return Application_Model_{$model} Populated model with out associations or NULL.
	 */
	public function get($itemID) {
		$result = $this->getMapper()->getDbTable()->find($itemID);
		if(count($result) == 0) {
		    throw new UnderflowException('No ' . $modelName . 's found for key ' . $itemID);	
		}
		
		$item = $this->getModel();
		$this->getMapper()->fromDbObject($item, $result->current());
		return $item;
		
	}

	/**
	    Get the model for a given id from the database.
	    Populate the model and all it's associations.  If no model
	    is found, return NULL.

        @param int $itemID The id of the model to be retrieved and built.	 
 
	    @return Application_Model_{$model} Populated model with associations or NULL.
	 */
	public function getBuildAll($itemID) {
		$item = $this->get($itemID);
		$this->getBuilder()->build('all', $item);
		return $item;
	}
	
	/**
	    Determine whether a model exists for a given
	    id.  Return true if one exists, false otherwise.
	    
        @param int $itemID The id of the model to check for existence. 
     
	    @return boolean True if a item corresponding to itemID is found, false otherwise.
	 */
	public function exists($itemID) {
		$result = $this->getMapper()->getDbTable()->find($itemID);
		if(count($result) == 0) {
			return false;
		} else {
			return true;
		}
	}
	
}

?>
