<?php
class Application_Model_Mapper_Recipe extends Application_Model_Mapper_Base {

   
	/**

	*/ 
    public function tagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $tagged = $db->fetchAll('
            SELECT *
                FROM recipe_tags
                WHERE ' . $db->quoteInto('recipe_id=?', $recipe->getRecipeID()) . '
                AND ' . $db->quoteInto('tag_id=?', $tag->getTagID()));

        if(count($tagged) == 0) {
            $db->query('INSERT INTO recipe_tags (recipe_id, tag_id) VALUES (?, ?)', array($recipe->getRecipeID(), $tag->getTagID()));
        }
    }
	
	/**

	*/
    public function untagRecipe(Application_Model_Recipe $recipe, Application_Model_Tag $tag) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('DELETE FROM recipe_tags WHERE recipe_id = ? AND tag_id = ?', array($recipe->getRecipeID(), $tag->getTagID()));
    }

	/**

	*/
    public function incrementViews(Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('update recipes set views=views+1 where id=?', array($recipe->getRecipeID()));    
    }
   
	/**

	*/ 
	public function voteUp(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array(
                'recipe_id'=>$recipe->getRecipeID(),
                'user_id'=>$user->getUserID(),
                'vote'=>1,
                'created'=>new Zend_Db_Expr('NOW()'),
                'modified'=>new Zend_Db_Expr('NOW()')
        );
        
        $db->insert('recipe_votes', $data); 
    }
     
	/**

	*/   
    public function voteDown(Application_Model_User $user, Application_Model_Recipe $recipe) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array(
                'recipe_id'=>$recipe->getRecipeID(),
                'user_id'=>$user->getUserID(),
                'vote'=>-1,
                'created'=>new Zend_Db_Expr('NOW()'),
                'modified'=>new Zend_Db_Expr('NOW()')
        );
   
     
        $db->insert('recipe_votes', $data); 
    }

	/**
	
	*/
    public function attachImage(Application_Model_Recipe $recipe, Application_Model_Image $image) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $attached = $db->fetchAll('
            SELECT * 
                FROM recipe_images
                WHERE ' . $db->quoteInto('recipe_id=?', $recipe->getRecipeID()) . 
                    ' AND ' . $db->quoteInto('image_id=?', $image->getImageID()));

        if(count($attached) == 0) {
            $sql = '
                INSERT INTO recipe_images (recipe_id, image_id)
                    VALUES (' . $db->quoteInto('?', $recipe->getRecipeID()) . ', ' . $db->quoteInto('?', $image->getImageID()) . ')';
            $db->query($sql);
        }
    }



}

?>
