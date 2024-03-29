<?php
/**
*
*/
class Application_Model_Persistor_Tag extends Application_Model_Persistor_Abstract {
    private $_mapper;
    
    // {{{ getMapper():                                                     protected Application_Model_Mapper_Tag
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_Tag();
        }
        return $this->_mapper;
    }
    
    // }}}

    // {{{ save(Application_Model_Tag $tag):                                public void
    
    public function save(Application_Model_Tag $tag) {
        if($tag->getTagID()) {
            $this->update($tag);
        } else {
            $this->insert($tag);
        }
    }
    
    // }}}

    // {{{ delete(Application_Model_Tag $tag):                                    public void
    
    public function delete(Application_Model_Tag $tag) {
        parent::deleteRaw($tag->getTagID());
    }

    // }}}
    // {{{ insert(Application_Model_Tag $tag):                              protected void

    protected function insert(Application_Model_Tag $tag) {
        $data = $this->getMapper()->toDbArray($tag);
        $tag->setTagID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_Tag $tag):                              protected void
    
    protected function update(Application_Model_Tag $tag) {
        $data = $this->getMapper()->toDbArray($tag);
        parent::updateRaw($data, $tag->getTagID()); 
    }

    // }}}
}
?>
