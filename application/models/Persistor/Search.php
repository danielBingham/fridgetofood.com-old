<?php

class Application_Model_Persistor_Search extends Application_Model_Persistor_Abstract {

    // {{{ save(Application_Model_Search $search):                          public void
    
    public function save(Application_Model_Search $search) {
        if(!$search->getSearchID()) {
            $search->created = Zend_Date::now(); 
        } 
        parent::save($search);
   }

    // }}}

}

?>
