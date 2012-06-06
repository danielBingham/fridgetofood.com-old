<?php
/**
*
*/
class Application_Service_Ribbon_Grant {

    public function grantRibbon(Application_Model_User $user, $name) {
        $ribbon = Application_Model_Query_Ribbon::getInstance()->fetchOne(array($name));

        if(empty($ribbon)) {
            throw new RuntimeException('That ribbon does not exist!');
        }

        $mapper = new Application_Model_Mapper_Ribbon();
        $mapper->grantRibbonToUser($user, $ribbon); 
    }

}
?>
