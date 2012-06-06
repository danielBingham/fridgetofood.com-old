<?php
/**
*
*
*/
class Application_Service_Translator_Recipe_FullForm_Section {
    private $sections = array();
 
    // {{{ protected getSection($title=null)

    protected function getSection($title=null, $sectionID=null) {
        // If the title is null, we're looking for the main section.
        if($title === null) {
            if(!isset($this->sections['main']) || empty($this->sections['main'])) {
                $section = new Application_Model_RecipeSection();
                $section->setMain(true);
                $this->sections['main'] = $section;
                return $section;
            } else {
                return $this->sections['main'];
            }
        }

        // Otherwise, check to see if the section exists. 
        foreach($this->sections as $section) {
            if($section->getTitle() == $title) {
                return $section;
            } 
        }

        // If it doesn't, create it and return it.
        $section = new Application_Model_RecipeSection();
        $section->setTitle($title);
        $this->sections[] = $section;
        return $section;
    }

    // }}}
    // {{{ protected getIngredient(array $i)
    
    public function getIngredient(array $i) {
        $recipeIngredient = new Application_Model_RecipeIngredient();
        $recipeIngredient->setPreparation($i['preparation']);
        $recipeIngredient->setAmount($i['amount']);
        
        $ingredients = Application_Model_Query_Ingredient::getInstance()->fetchAll(array('name'=>$i['Ingredient']['name']));
        if(count($ingredients) !== 1) {
            $ingredient = new Application_Model_Ingredient();
            $ingredient->setName($i['Ingredient']['name']);
            $recipeIngredient->setIngredient($ingredient); 
        } else {
            $recipeIngredient->setIngredient($ingredients[0]);
        }   

        return $recipeIngredient; 
    }    

    // }}} 
    // {{{ protected getInstruction(array $i)
    
    protected function getInstruction(array $i) {
        $instruction = new Application_Model_RecipeInstruction();
        $instruction->setNumber($i['number']);
        $instruction->setContent($i['content']); 
       
        return $instruction; 
    }

    // }}} 
    // {{{ public translate(Application_Model_Recipe &$recipe, array $post)

    public function translate(Application_Model_Recipe &$recipe, array $post) {
        foreach($post['IngredientSection'] as $s) {
            $section = $this->getSection(isset($s['title']) && !empty($s['title']) ? $s['title'] : null);

            $recipeIngredients = array();
            foreach($s['Ingredient'] as $i) {
                if(!empty($i['Ingredient']['name'])) {  
                   $recipeIngredients[] = $this->getIngredient($i); 
                }
            }

            $section->setRecipeIngredients($recipeIngredients);
        }
        foreach($post['InstructionSection'] as $s) {
            $section = $this->getSection(isset($s['title']) && !empty($s['title']) ? $s['title'] : null);

            $recipeInstructions = array();
            foreach($s['Instruction'] as $i) {
                if(!empty($i['content'])) {    
                    $recipeInstructions[] = $this->getInstruction($i);
                }
            }

            $section->setRecipeInstructions($recipeInstructions);
        }
 
        $recipe->setRecipeSections($this->sections);
    }

    // }}}
}
?>
