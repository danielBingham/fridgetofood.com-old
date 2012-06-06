<?php
class Application_Service_Paginator_Adapter_Recipe_UsingIngredient
	extends Application_Service_Paginator_Adapter_Recipe_Abstract {
		
	public function __construct(Application_Model_Ingredient $ingredient, $order) {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('recipes'),
			array(
				'*',
				'votes'=> '(select COALESCE(SUM(COALESCE(recipe_votes.vote, 0)), 0) from recipe_votes where recipe_votes.recipe_id= recipes.id)'
			)
		)->where('id in (select recipe_id from recipe_items where ingredient_id=?)', $ingredient->getIngredientID());
		
		switch($order) {
			case 'newest':
				$select->order('created desc')->order('views asc');
				break;
			case 'votes':
				$select->order('votes desc')->order('views asc');
				break;
			case 'views':
				$select->order('views desc');
				break;
			default:
				$select->order('created desc');
				break;
		}
		
		parent::__construct($select);
		
	}
		
}

?>