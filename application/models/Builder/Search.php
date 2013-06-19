<?php

class Application_Model_Builder_Search extends Application_Model_Builder_Abstract {

    public function __construct() {
        $this->_haveBuilt = array(
            'searchResults'=>false
        );
    }

    public function buildSearchResults(Application_Model_Search $search) {
        $search->setSearchResults(Application_Model_Query_SearchResults::getInstance()->fetchAll(array('search_id'=>$search->getSearchID())));
    }

}

?>
