<?php
/**
*
*/
class Application_Service_Translator_Recipe_ShortForm_Ingredients {

    // {{{ isMeasurement($word):                                            protected boolean

	protected function isMeasurement($word) {
        $db = Zend_Db_Table::getDefaultAdapter();
		$r = $db->fetchAll('select measurement_id from measurement_aliases where alias=?', array($word));
		if(!empty($r)) {
			return true;
		}
		else {
			return false;
		}
	}

    // }}}
    // {{{ isPrepWord($word):                                               protected boolean
	
	protected function isPrepWord($word) {
        $db = Zend_Db_Table::getDefaultAdapter();
		$r = $db->fetchAll('select id from words_preparation where word=?', array($word));
		if(!empty($r)) {
			return true;
		}
		else {
			return false;
		}	
	}

    // }}}
    // {{{ translate(Application_Model_RecipeSection $section, $text):      public boolean 

    public function translate(Application_Model_RecipeSection &$section, $text) {
    	$ingredientLines = explode("\n", $text);
         
 
        $ingredients = array();	
        foreach($ingredientLines as $line) {
            $line = trim($line);
			if(empty($line)) {
				continue;	
			}
            // TODO: Why are we replacing periods with nada before we explode?
            $cleanedLine = str_replace('.', '', $line);
			$words = explode(' ', $cleanedLine);
	
			$amount='';
			$ingredient='';
			$preparation='';
			
			$paren = 0;
			$comma = false;
		
            // If we find the word 'of' as we search from the
            // start of the line, then we've found the amount.
            // Take it out of the line and place it into the
            // amount placeholder variable.	
			for($w=0; $w < count($words); $w++) {
				if($words[$w] == 'of') {
					for($i = 0; $i < $w; $i++) {
						$amount .= trim($words[$i]).' ';
						unset($words[$i]);	
					}
					unset($words[$w]);
					break;
				}
			}
			
		    // Now do the primary parse.  We'll need to 
            // check each word and do special stuff to certain
            // words or classes of words.	
			foreach($words as $word) {
				$word = trim($word);
				if(empty($word)) {
					continue;
				}

                // If we find a close paren, then we've found
                // the end of this particular preparation portion.
                // Turn off paran, and append this word to preparation.	
                if(strpos($word, ')') !== false) {
                    $preparation .= trim($word).' ';
					$paren--;	
			
                // If $paran is on then we are in a set of
                // parenthesis and this is the preparation.
                // Attach this word to prep.	
                } else if($paren > 0) {
					$preparation .= trim($word).' ';
			
                // If we hit an open paren, then this
                // is part of the preparation, turn on
                // $paran and add this to the preparation.
                } else if(strpos($word, '(') !== false) {
					$preparation .= trim($word).' ';
					$paren++;
			
                // If the word is a straight up numeric and we're not in a paren,
                // then it is part of the amount, place it there.
				} else if(is_numeric($word)) {
					$amount .= trim($word).' ';
			
                // If the word contains the '/' character then
                // it may be a fraction. We'll need to test each
                // part of it to find out.	
                } else if(strpos($word, '/') !== false) {
					$fraction = explode('/', $word);
					$t = true;
					foreach($fraction as $num) {
						if(!is_numeric($num)) {
							$t = false;
							break;	
						}
					}
					
					if($t) {
						$amount .= trim($word).' ';	
					}

                // If the word is a measurement word
                // then this is part of the amount.
				} else if($this->isMeasurement(strtolower($word))) {
					$amount .= trim($word).' ';	
			
                // If the word is one of the following, then
                // it is part of the amount.	
                } else if($word == 'large' || $word == 'medium' || $word == 'small') {
					$amount .= trim($word).' ';	
		        
                // If we've hit a comma, then everthing after
                // the comma is preparation.  	
                }  else if($comma) {
					$preparation .= trim($word).' ';	
			    
                // If we hit a comma, add this word
                // to ingredient an then turn on $comma.
                // Everything after the comma is part of
                // the preparation.	
                } else if(strpos($word, ',') !== false) {
					$ingredient .= str_replace(',', '', trim($word)).' ';
					$comma = true;

                // If this is a preparation word, then it is a
                // part of the preparation.	
				} else if($this->isPrepWord($word)) {
					$preparation .= trim($word).' ';

                // If none of the others have hit, then
                // this is part of the ingredient name.	
				} else {
					$ingredient .= trim($word).' ';	
				}
			}
			$ingredientName = trim($ingredient);
	        
            $recipeIngredient = new Application_Model_RecipeIngredient();
            $recipeIngredient->setAmount(trim($amount));
            $recipeIngredient->setPreparation(trim($preparation));	
 
           
            $potentialIngredients = Application_Model_Query_Ingredient::getInstance()->fetchAll(array('name'=> $ingredientName));
            
            if(count($potentialIngredients) == 1) {
                $ingredient = $potentialIngredients[0];
            } else {
                $ingredient = new Application_Model_Ingredient();
                $ingredient->setName($ingredientName);
            }
            $recipeIngredient->setIngredient($ingredient);
            $ingredients[] = $recipeIngredient;
        }
        $section->setRecipeIngredients($ingredients);
        return true;
    }

    // }}}

}
?>
