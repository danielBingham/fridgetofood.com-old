<?php

class Application_Service_Paginator_Adapter_Recipe_Search extends Application_Service_Paginator_Adapter_Recipe_Abstract {

    public function __construct(Application_Model_Search $search, $order='relevance') {
        $select = Zend_Db_Table::getDefaultAdapter()->select();
        $select->from ('recipes', array(
				    '*',
				    'votes'=> '(select COALESCE(SUM(COALESCE(recipe_votes.vote, 0)), 0) from recipe_votes where recipe_votes.recipe_id= recipes.id)'
                ))
               ->join('search_results', 'recipes.id = search_results.recipe_id', array('relevance'))
               ->where('search_results.search_id=?', $search->getSearchID());

        
        switch($order) {
			case 'newest':
				$select->order('recipes.created desc')->order('recipes.views asc');
				break;
			case 'votes':
				$select->order('votes desc')->order('recipes.views asc');
				break;
			case 'views':
				$select->order('recipes.views desc');
				break;
            case 'relevance':
                $select->order('search_results.relevance desc');
			default:
				$select->order('created desc');
				break;
		}
		
		parent::__construct($select);

    }


}

?>
