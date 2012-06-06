<?php
/**
*
*
*/
class Application_Service_Translator_Recipe_Tag {

    // {{{ public getTag($name)

    private function getTag($name) {
        $tags = Application_Model_Query_Tag::getInstance()->fetchAll(array('name'=>$name));
        if(count($tags) === 1) {
            return $tags[0]; 
        }
        $tag = new Application_Model_Tag();
        $tag->setType('general');
        $tag->setName($name);
        return $tag;
    }
    
    // }}}
    // {{{ public translate(Application_Model_Recipe &$recipe, array $post)

    public function translate(Application_Model_Recipe &$recipe, $tagList) {
        $tagNames = array_map('trim', explode(',', $tagList));
       
        $tags = array(); 
        foreach($tagNames as $name) {
            if(empty($name)) {
                continue;
            } 
            $tags[] = $this->getTag($name); 
        }
        $recipe->setTags($tags);
    }

    // }}}

}
?>
