<?php

/**
*
*
*
*
*/

class Application_Service_Translator_Recipe_FullForm {

    // {{{ private processURL($url)

    /**
    * Ensure that a given text is a valid url.  If no 'http://' is
    * found, prepend it.  If the url only contains 'http://' then 
    * it is an empty url.
    */
    private function processURL($url) {
        if($url === 'http://') {
            return '';
        }
        if(!empty($url) && strpos($url, 'http://') === false) {
            return 'http://' . $url;
        }   
        return $url;
    }

    // }}}  
    // {{{ public boolean translate(Application_Model_Recipe &$recipe, array $post)
    
    public function translate(Application_Model_Recipe &$recipe, array $post) {
        $recipe->setTitle($post['recipe']['title']);
        $recipe->setUrlTitle(urlencode(str_replace(' ', '-', strtolower($post['recipe']['title']))));
        $recipe->setIntro($post['recipe']['intro']);
        $recipe->setBlogURL($this->processURL($post['recipe']['blog_url']));
        $recipe->setSource($post['recipe']['source']);
        $recipe->setSourceURL($this->processURL($post['recipe']['source_url'])); 
        $recipe->setPreparationTime($post['recipe']['preparation_time']);
        $recipe->setServes($post['recipe']['serves']);       
        if($recipe->getViews() < 1) { 
            $recipe->setViews(0);
        }

        if(isset($post['recipe']['is_community'])) {
            $recipe->setCommunity(true);
        }
 
        // Handle the ingredient and instruction sections. 
        $sectionTranslator = new Application_Service_Translator_Recipe_FullForm_Section();
        $sectionTranslator->translate($recipe, $post['recipe']); 

        // Handle the tags. 
        $tagTranslator = new Application_Service_Translator_Recipe_Tag();
        $tagTranslator->translate($recipe, $post['recipe']['tags']); 
        
        // Finally set the recipe's user.  The owner of the recipe
        // is usually the person logged in when the recipe is added.
        $recipe->setUser(Zend_Auth::getInstance()->getIdentity());
        return true;
    }

    // }}}
    // {{{ public getErrors()

    public function getErrors() {

    }
    
    // }}}

}

?>
