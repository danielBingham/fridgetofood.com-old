<?php
/**
*
*/
class Application_Service_Recipe_View {
   
    // {{{ view(Application_Model_Recipe $recipe):              public void
 
    public function view(Application_Model_Recipe $recipe) {
        $mapper = new Application_Model_Mapper_Recipe();
        $mapper->incrementViews($recipe);
    }

    // }}}

}
?>
