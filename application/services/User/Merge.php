<?php
/**
*
*/
class Application_Service_User_Merge {

    // {{{ merge(Application_Model_User $into, Application_Model_User $from):                       public void
    
    /**
    * Merge two user accounts into a single account and delete the superfluous one.  Transfer
    * all recipes, photographs, votes, reputation bonuses and associated social media.  Uses
    * the $into account as the base and the $from account as the account being merged.  At
    * the end of the merge the $from account will be deleted.  Profile information will be
    * retained for the $into account, not the $from account.  
    */
    public function merge(Application_Model_User $into, Application_Model_User $from) {
        $persistor = new Application_Model_Persistor_Recipe(); 
        foreach($from->getRecipes() as $recipe) {
            $recipe->setUserID(into->getUserID());
            $persistor->save($recipe);
        }

        $persistor = new Application_Model_Persistor_Image();
        foreach($from->getImages() as $image) {
            $image->setUserID($into->getUserID());
            $persistor->save($image);
        }

        $mapper = new Application_Model_Mapper_user();
        $mapper->mergeAssociations($into, $from); 
        $mapper->mergeReputation($into, $from); 
        
    }
    
    // }}}
}
?>
