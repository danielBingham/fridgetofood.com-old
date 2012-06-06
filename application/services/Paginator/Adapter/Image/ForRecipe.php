<?php
class Application_Service_Paginator_Adapter_Image_ForRecipe
	extends Application_Service_Paginator_Adapter_Image_Abstract {

	public function __construct(Application_Model_Recipe $recipe, $order='') {
		$select = Zend_Db_Table::getDefaultAdapter()->select()->from(
			array('images'),
			array(
				'*',
				'votes'=> '(select coalesce(sum(image_votes.vote), 0) from image_votes where image_id=images.id)'
			)
		);
		$select->where('id in (select image_id as id from recipe_images where recipe_id=?)', $recipe->getRecipeID());
		
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
				$select->order('votes desc');
				break;
		}
		parent::__construct($select);
	}
		
}
	
?>