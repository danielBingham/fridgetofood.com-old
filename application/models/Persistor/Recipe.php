<?php
/**
*
*/
class Application_Model_Persistor_Recipe extends Application_Model_Persistor_Abstract {
    private $_mapper;

    // {{{ getMapper():                                                     protected Application_Model_Mapper_Recipe
    
    protected function getMapper() {
        if(empty($this->_mapper)) {
            $this->_mapper = new Application_Model_Mapper_Recipe(); 
        }
        return $this->_mapper;
    }

    // }}} 
    // {{{ clear(Application_Model_Recipe $recipe:                          public void

    public function clear(Application_Model_Recipe $recipe) {
        $old = Application_Model_Query_Recipe::getInstance()->get($recipe->getRecipeID());
       

        // FIXME Clear shouldn't be getting called if this is a new recipe. 
        if($old !== null) { 
            $persistor = new Application_Model_Persistor_RecipeSection();
            foreach($old->getRecipeSections() as $section) {
                $persistor->delete($section);
            }
            unset($persistor);

            foreach($old->getTags() as $tag) {
                $this->getMapper()->untagRecipe($recipe, $tag);
            }
        }
    }

    // }}}

    // {{{ save(Application_Model_Recipe $recipe):                          public void
    
    public function save(Application_Model_Recipe $recipe) {
        if($recipe->getRecipeID()) {
            $this->update($recipe);
        } else {
            $this->insert($recipe);
        }

        $persistor = new Application_Model_Persistor_RecipeSection();
        foreach($recipe->getRecipeSections() as $section) {
            $section->setRecipeID($recipe->getRecipeID());
            $persistor->save($section); 
        }
        unset($persistor);

        $persistor = new Application_Model_Persistor_Tag();    
        foreach($recipe->getTags() as $tag) {
            $persistor->save($tag);
            $this->getMapper()->tagRecipe($recipe, $tag);
        }
        unset($persistor); 

        if($recipe->getImages()) {
           foreach($recipe->getImages() as $image) {
                $this->getMapper()->attachImage($recipe, $image);
            } 
        }

   }

    // }}}

    // TODO: Delete needs to be rewritten to delete associations.
    // {{{ delete(Application_Model_Recipe $recipe):                        public void

    public function delete(Application_Model_Recipe $recipe) {
        // This will clear away all the editable associated data.
        $this->clear($recipe); 
        
        // TODO: That leaves images, comments, and votes.
        // TODO: Decide what to do with images associated with a deleted
        // recipe.  Leave them for now, they can always be cleared later.

          
        parent::deleteRaw($recipe->getRecipeID());
    }

    // }}}
    // {{{ insert(Application_Model_Recipe $recipe):                        protected void
    
    protected function insert(Application_Model_Recipe $recipe) {
        $recipe->setCreated(Zend_Date::now());
        $recipe->setModified(Zend_Date::now());
        
        $data = $this->getMapper()->toDbArray($recipe);
        $recipe->setRecipeID(parent::insertRaw($data));
    }

    // }}}
    // {{{ update(Application_Model_Recipe $recipe):                        protected void

    protected function update(Application_Model_Recipe $recipe) {
        $recipe->setModified(Zend_Date::now());
        
        $data = $this->getMapper()->toDbArray($recipe);
        parent::updateRaw($data, $recipe->getRecipeID());
    }

    // }}}

}
?>
