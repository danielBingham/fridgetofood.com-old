<?php
/**
*
*/
class Application_Service_Recipe_Comment {
    
    public function comment(Application_Model_User $user, $recipeID, $comment) {
        $recipeComment = new Application_Model_RecipeComment(false);
        $recipeComment->setUser($user); 
        $recipeComment->setRecipeID($recipeID);
        $recipeComment->setContent($comment);

        $persistor = new Application_Model_Persistor_RecipeComment();
        $persistor->save($recipeComment);
    }

}

?>
