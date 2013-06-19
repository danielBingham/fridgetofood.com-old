<?php

class Application_Model_Builder_SearchResult extends Application_Model_Builder_Abstract {

    public function __construct() {
        $this->_haveBuilt = array(
            'recipe'=>false,
            'search'=>false
        );
    }

    public function buildRecipe(Application_Model_SearchResult $searchResult) {
        $searchResult->setRecipe(Application_Model_Query_Recipe::getInstance()->get($searchResult->getRecipeID()));
    }

    public function buildSearch(Application_Model_SearchResult $searchResult) {
        $searchResult->setSearch(Application_Model_Query_Search::getInstance()->get($searchResult->getSearchID()));
    }

}

?>
