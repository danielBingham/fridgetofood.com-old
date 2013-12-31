<?php
/**
*
*/
class Application_Service_Translator_Recipe_ShortForm {

    // {{{ processURL($url):                                                public string

    /**
    * Ensure that a given text is a valid url.  If no 'http://' is
    * found, prepend it.  If the url only contains 'http://' then 
    * it is an empty url.
    */
    private function processURL($url) {
        if($url === 'http://') {
            return '';
        }
        if(strpos($url, 'http://') === false) {
            return 'http://' . $url;
        }
        return $url;   
    }

    // }}}  
    // {{{ translate(Application_Model_Recipe $recipe, $post):              public boolean

    public function translate(Application_Model_Recipe $recipe, $post) {
        $recipe->setTitle($post['recipe']['title']);
        $recipe->setUrlTitle(urlencode(str_replace(' ', '-', strtolower($post['recipe']['title'])))); 
        $recipe->setIntro($post['recipe']['intro']);
        $recipe->setBlogURL($this->processURL($post['recipe']['blog_url']));
        $recipe->setSource($post['recipe']['source']);
        $recipe->setSourceURL($this->processURL($post['recipe']['source_url'])); 
        $recipe->setPreparationTime($post['recipe']['preparation_time']);
        $recipe->setServes($post['recipe']['serves']);       
        $recipe->setViews(0); 

        $sections = array(); 
        $section = new Application_Model_RecipeSection();
        $section->setMain(true);

        $translator = new Application_Service_Translator_Recipe_ShortForm_Ingredients();
        $translator->translate($section, $post['recipe']['ingredients']); 
       
        $translator = new Application_Service_Translator_Recipe_ShortForm_Instructions();
        $translator->translate($section, $post['recipe']['instructions']);

        $recipe->setRecipeSections(array($section));

        $translator = new Application_Service_Translator_Recipe_Tag();
        $translator->translate($recipe, $post['recipe']['tags']); 
 
        $recipe->setUser(Zend_Auth::getInstance()->getIdentity());          
        return true; 
    }

    // }}}
    // {{{ getErrors():                                                     public array
    
    public function getErrors() {
        return array();
    }
    
    // }}}


}
?>
