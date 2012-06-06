<?php
/**
*
*/
class Application_Service_Translator_Recipe_ShortForm_Instructions {

    // {{{ translate(Application_Model_RecipeSection $section, $instructions):                  public boolean

    public function translate(Application_Model_RecipeSection $section, $instructions) {
		$instructionList = explode("\n", $instructions);
		$number = 1;
	
        $instructions = array();	
		foreach($instructionList as $content) {
            $content = trim($content);
			if(empty($content)) {
				continue;	
			}
            $instruction = new Application_Model_RecipeInstruction();		
            $instruction->setContent(trim($content));
            $instruction->setNumber($number);
            $instructions[] = $instruction;	
			$number++;
		}
        $section->setRecipeInstructions($instructions);
        return true;
    }

    // }}}

}
?>
