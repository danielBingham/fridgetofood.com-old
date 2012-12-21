<?php
/**
*
*/
class Application_Model_Persistor_Tag extends Application_Model_Persistor_Abstract {

    // {{{ save(Application_Model_Tag $tag):                                public void
    
    public function save(Application_Model_Tag $tag) {
        if($tag->getTagID()) {
            $tag->modified = Zend_Date::now();
        } else {
            $tag->created = Zend_Date::now();
            $tag->modified = Zend_Date::now();
        }
    }
    
    // }}}

}
?>
