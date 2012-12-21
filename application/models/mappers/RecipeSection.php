<?php
class Application_Model_Mapper_RecipeSection extends Application_Model_Mapper_Base {
	
	
	public function fromDbArray(Application_Model_RecipeSection $recipeSection, array $data) {
        parent::fromDbArray($recipeSection, $data);
        $recipeSection->base = ($recipeSection->base == 1 ? true : false);
	}
	
	public function toDbArray(Application_Model_RecipeSection $recipeSection) {
        $data = parent::toDbArray($recipeSection);
        $data['base'] = ($data['base'] ? 1 : 0);
		return $data;
	}
	
}
?>
