<?php
/**
*
*/
abstract class Application_Model_Persistor_Abstract {

    protected abstract function getMapper();

    // {{{ insert(array $data):                                                   protected int

    protected function insertRaw(array $data) {
        return $this->getMapper()->getDbTable()->insert($data);
    }

    // }}}
    // {{{ update(array $data, $id):                                        protected void

    protected function updateRaw(array $data, $id) {
        $this->getMapper()->getDbTable()->update($data, $this->getMapper()->getDbTable()->getAdapter()->quoteInto('id=?', $id));
    }
    
    // }}}
    // {{{ delete($id):                                                     protected void

    protected function deleteRaw($id) {
        $this->getMapper()->getDbTable()->delete($this->getMapper()->getDbTable()->getAdapter()->quoteInto('id=?', $id));
    }

    // }}}
}

?>
