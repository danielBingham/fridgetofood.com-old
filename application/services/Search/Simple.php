<?php

class Application_Service_Search_Simple {
    private $_db;
    private $_search;
    
    const TITLE_RELEVANCE = 10;
    const EXACT_INGREDIENT_RELEVANCE = 8;
    const PARTIAL_INGREDIENT_RELEVANCE = 1; 

    // {{{ db():                                                            private Zend_Db_Adapter
    private function db() {
        if(empty($this->_db)) {
            $this->_db = Zend_Db_Table::getDefaultAdapter();
        }
        return $this->_db;
    }

    // }}}
    // {{{ getSearch():                                                     private Application_Model_Search
    
    private function getSearch() {
        return $this->_search;
    }

    // }}}
    // {{{ setSearch(Application_Model_Search $search):                     private void

    private function setSearch(Application_Model_Search $search) {
        $this->_search = $search;
        return $this;
    }

    // }}}

    // {{{ search($title=null, $ingredients=null, $tags=null):              public Application_Model_Search

    public function search($title=null, $ingredients=null, $tags=null) {
        $this->setSearch(new Application_Model_Search(false));
        $this->getSearch()->setQuery('t='.$title.'&i='.$ingredients.'&tg='.$tags);
        $this->getSearch()->setCreated(Zend_Date::now());

		if($title !== null) {
			$this->getSearch()->setSearchResults($this->performTitleSearch($title));
        }
		
		if($ingredients !== null && $title !== null) {
            $this->performIngredientFilter($ingredients);
		}
		else if($ingredients !== null) {
            $this->getSearch()->setSearchResults($this->performIngredientSearch($ingredients));
		}
		
		
		if($tags !== null && ($ingredients !== null || $title !== null)) {
			$this->performTagFilter($tags);
		}
		else if($tags !== null) {
			$this->getSearch()->setSearchResults($this->performTagSearch($tags));	
		}

        $persistor = new Application_Model_Persistor_Search();
        $persistor->save($this->getSearch());

        return $this->getSearch();
    }

    // }}}
    // {{{ performTitleSearch($title):                                      protected array(Application_Model_SearchResult)

    protected function performTitleSearch($title) {
	    $sql = 'SELECT id, '
                . $this->db()->quoteInto('MATCH(title) AGAINST(?) as relevance', $title)
                . ' FROM recipes WHERE '
                . $this->db()->quoteInto('MATCH(title) AGAINST(?)', $title);
        $recipes = $this->db()->fetchAll($sql);	

        $searchResults = array();       	
        foreach($recipes as $recipe) {
	        $searchResult = new Application_Model_SearchResult();     	
            $searchResult->setRecipeID($recipe['id']);
            $searchResult->setRelevance($recipe['relevance']);
            $searchResults[] = $searchResult;
        }
        return $searchResults;
    }

    // }}}
    // {{{ performIngredientFilter($query):                                 protected void 

    protected function performIngredientFilter($query) {
		$tokens = array_map('trim', explode(',', $query));
		
		
		/**
		 * First thing, find the ingredient matches.
		 * 		Build two arrays -- Matches and Filters.
		 * 		Matches are ingredients that are wanted, Filters are ingredients that aren't wanted (-flour)
		 * 		Give them relevances
		 * 		For Filters with high relevance (exact match) those recipes will be unset
		 * 		For Filters with low relevance (partial match) those recipes will have -1 relevance
		 * 
		 * 		At the end of this code we will have two arrays with ingredient ids and relevances.
		 **/
		$ingredientMatches = array();
		$ingredientFilters = array();
		$matches = 0;
		$filters = 0;
		foreach($tokens as $token) {
			if(strpos($token, '-') === 0) {
				$token = substr($token, 1);
				$exact = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE name=? LIMIT 1', array($token)));
				if(!empty($exact[0]['id'])) {
					$ingredientFilters[$filters]['id'] = $exact['id'];
					$ingredientFilters[$filters]['relevance'] = self::EXACT_INGREDIENT_RELEVANCE;
					$filters++; 
				}
				
				$partial = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE MATCH(name) AGAINST(?)', array($token)));
				if(!empty($partial)) {
					foreach($partial as $match) {
						$ingredientFilters[$filters]['id'] = $match['id'];
						$ingredientFilters[$filters]['relevance'] = self::PARTIAL_INGREDIENT_RELEVANCE;
						$filters++;
					}
				}
			}
			else {
				$exact = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE name=? LIMIT 1', array($token)));
				if(!empty($exact[0]['id'])) {
					$ingredientMatches[$matches]['id'] = $exact['id'];
					$ingredientMatches[$matches]['relevance'] = self::EXACT_INGREDIENT_RELEVANCE;
					$matches++;	
				}
	
				$partial = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE MATCH(name) AGAINST(?)', array($token)));
				if(!empty($partial)) {
					foreach($partial as $match) {
						$ingredientMatches[$matches]['id'] = $match['id'];
						$ingredientMatches[$matches]['relevance'] = self::PARTIAL_INGREDIENT_RELEVANCE;	
						$matches++;	
					}
				}
			}
		}
		
		/**
		 * Take the ingredient arrays and build two arrays of recipe ids and relevances.
		 * 		recipeMatches will contain recipes that are a match, with an associated relevance generated by ingredients.
		 * 		recipeFilters will contain recipes that are to be filtered.  There is no relevance associated with these,
		 * 			because they will be removed from the final arrays.
		 **/
		
		$recipeMatches = array();
		$recipeFilters = array();
		$matches = 0;
		$filters = 0;
		foreach($ingredientMatches as $ingredient) {
			$recipes = $this->db()->fetchAll($this->db()->quoteInto('SELECT recipe_id FROM recipe_items WHERE ingredient_id=?', 
                                                                            array($ingredient['id'])));
			foreach($recipes as $recipe) {
				if(!isset($recipeMatches[$recipe['recipe_id']])) {
					$recipeMatches[$recipe['recipe_id']]['id'] = $recipe['recipe_id'];
					$recipeMatches[$recipe['recipe_id']]['relevance'] = $ingredient['relevance'];	
				}
				else {
					$recipeMatches[$recipe['recipe_id']]['relevance'] += $ingredient['relevance'];	
				}
			}
		}
		
		foreach($ingredientFilters as $filter) {
			$recipes = $this->db()->fetchAll($this->db()->quoteInto('SELECT recipe_id FROM recipe_items WHERE ingredient_id=?', array($filter['id'])));
			foreach($recipes as $recipe) {
				if($filter['relevance'] == self::EXACT_INGREDIENT_MATCH) {
					if(!isset($recipeFilters[$recipe['recipe_id']])) {
						$recipeFilters[$recipe['recipe_id']] = true;
					}
				}
				else {
					if(isset($recipeMatches[$recipe['recipe_id']])) {
						$recipeMatches[$recipe['recipe_id']]['relevance'] -= self::EXACT_INGREDIENT_RELEVANCE;
					}
				}
			}
		}
		
		/**
		 * Now use the recipeMatches and recipeFilters arrays to alter the $this->data['SearchResult'] array.
		 **/
        $searchResults = $this->getSearch()->getSearchResults();
        foreach($searchResults as $result) {
            if(isset($recipeMatches[$result->getRecipeID()])) {
                $result->setRelevance($result->getRelevance()+$recipeMatches[$result->getRecipeID()]['relevance']);
            }
        }
	    foreach($searchResults as $key=>$result) {
            if(isset($recipeFilters[$result->getRecipeID()])) {
                unset($searchResults[$key]);
            }
        }	
	    $this->getSearch()->setSearchResults($searchResults);	
		
	}

    // }}} 
    // {{{ performTagFilter($tagsString):                                   protected void

    public function performTagFilter($tagsString) {
		$tokens = array_map('trim', explode(',',$tagsString));
		
		$tags = array('match'=>array(), 'filter'=>array());
		foreach($tokens as $token) {
			if(strpos($token, '-') === 0) {
				$token = substr($token, 1);
		        $tags['filter'] = array_merge($tags['filter'], $this->db()->fetchAll($this->db()->quoteInto(
                    'SELECT recipe_tags.recipe_id AS recipe_id
                        FROM recipe_tags 
                            JOIN tags ON recipe_tags.tag_id = tags.id 
                        WHERE tags.name=?', $token)));
            }
			else {
		        $tags['match'] = array_merge($tags['match'], $this->db()->fetchAll($this->db()->quoteInto(
                    'SELECT recipe_tags.recipe_id AS recipe_id
                        FROM recipe_tags 
                            JOIN tags ON recipe_tags.tag_id = tags.id 
                        WHERE tags.name=?', $token)));

            }
        }

        $results = array();
        foreach($tags['match'] as $match) {
            $results[] = $match['recipe_id'];
        }
        $tags['match'] = $results;

        $results = array();
        foreach($tags['filter'] as $filter) {
            $results[] = $filter['recipe_id'];
        }
        $tags['filter'] = $results;

        $searchResults = array();
        foreach($this->getSearch()->getSearchResults() as $searchResult) {
            if(in_array($searchResult->getRecipeID(), $tags['match']) && !in_array($searchResult->getRecipeID(), $tags['filter'])) {
                $searchResults[] = $searchResult; 
            }
        }
        $this->getSearch()->setSearchResults($searchResults);
	}

    // }}}
    // {{{ performIngredientSearch($ingredientsString):                     protected void
 
	protected function performIngredientSearch($query) {
        $tokens = array_map('trim', explode(',', $query));
		
		$ingredientMatches = array();
		$ingredientFilters = array();
		$matches = 0;
		$filters = 0;
		foreach($tokens as $token) {

            // First, build the array of filters.  Ingredients that disqualify a recipe.
			if(strpos($token, '-') === 0) {
				$token = substr($token, 1);
				$exact = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE name=? LIMIT 1', $token));
				if(!empty($exact[0]['id'])) {
					$ingredientFilters[$filters] = $exact[0]['id'];
					$ingredientFilters[$filters] = self::EXACT_INGREDIENT_RELEVANCE; 
					$filters++; 
				}
				
				$partial = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE MATCH(name) AGAINST(?)', $token));
				if(!empty($partial)) {
					foreach($partial as $match) {
						$ingredientFilters[$filters] = $match['id'];
						$ingredientFilters[$filters] = self::PARTIAL_INGREDIENT_RELEVANCE;
						$filters++;
					}
				}

            // Next build the array of matches.  Ingredients we want to find in the recipe.
			} else {
				$exact = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE name=? LIMIT 1', $token));
				if(!empty($exact[0]['id'])) {
					$ingredientMatches[$matches]['id'] = $exact[0]['id'];
					$ingredientMatches[$matches]['relevance'] = self::EXACT_INGREDIENT_RELEVANCE;
					$matches++;	
				}
	
				$partial = $this->db()->fetchAll($this->db()->quoteInto('SELECT id FROM ingredients WHERE MATCH(name) AGAINST(?)', $token));
				if(!empty($partial)) {
					foreach($partial as $match) {
						$ingredientMatches[$matches]['id'] = $match['id'];
						$ingredientMatches[$matches]['relevance'] = self::PARTIAL_INGREDIENT_RELEVANCE;	
						$matches++;	
					}
				}
			}
		}
	
        $searchResults = array();	
		foreach($ingredientMatches as $ingredient) {
			$recipes = $this->db()->fetchAll($this->db()->quoteInto('SELECT recipe_id FROM recipe_items WHERE ingredient_id=?', $ingredient['id']));
			foreach($recipes as $recipe) {
				if(empty($searchResults[$recipe['recipe_id']])) {
                    $result = new Application_Model_SearchResult();
                    $result->setRecipeID($recipe['recipe_id']);
                    $result->setRelevance($ingredient['relevance']);
                    $searchResults[$recipe['recipe_id']] = $result;
				}
				else {
                    $searchResults[$recipe['recipe_id']]->setRelevance($searchResults[$recipe['recipe_id']]->getRelevance()+$ingredient['relevance']);
				}
			}
			
		}
		foreach($ingredientFilters as $filter) {
			$recipes = $this->db()->fetchAll($this->db()->quoteInto('SELECT recipe_id FROM recipe_items WHERE ingredient_id=?', $filter['id']));
			foreach($recipes as $recipe) {
				if(!isset($searchResults[$recipe['id']])) {
					continue;
				}
				else {
					if($filter['relevance'] == self::EXACT_INGREDIENT_RELEVANCE) {
						unset($searchResults[$recipe['id']]);	
					}
					else {
						$searchResults[$recipe['id']]->setRelevance($searchResults[$recipe['id']]->getRelevance() - self::EXACT_INGREDIENT_RELEVANCE);
                    }
				}
			}
		}
        return $searchResults;
	}

    // }}}
    // {{{ performTagSearch($query):                                        protected void

    // TODO Improve this to give greater weight to recipes that match
    // more of the tags.
    public function performTagSearch($query) {
		$tokens = array_map('trim', explode(',', $query));
		
		
        $sql = 'SELECT DISTINCT recipe_tags.recipe_id 
                    FROM recipe_tags 
                        JOIN tags ON recipe_tags.tag_id = tags.id ';
        $match = '';
        $filter = ''; 
        foreach($tokens as $token) {
			if(strpos($token, '-') === 0) {
				$token = substr($token, 1);
		        $filter .= (!empty($filter) ? ' AND ' : '') . $this->db()->quoteInto('tags.name != ?', $token);	
            }
			else {
		        $match .= (!empty($match) ? ' OR ' : '') . $this->db()->quoteInto('tags.name = ?', $token);	
            }
		}

        if(!empty($filter) && !empty($match)) {
            $sql .= sprintf('WHERE (%s) AND (%s) ORDER BY recipe_tags.recipe_id', $match, $filter);
        } else if(!empty($filter)) {
            $sql .= sprintf('WHERE (%s) ORDER BY recipe_tags.recipe_id', $filter);
        } else if(!empty($match)) {
            $sql .= sprintf('WHERE (%s) ORDER BY recipe_tags.recipe_id', $match);
        }

       
        $results = $this->db()->fetchAll($sql);
        
        $searchResults = array();
        foreach($results as $recipe) {
            $searchResult = new Application_Model_SearchResult();
            $searchResult->setRecipeID($recipe['recipe_id']);
            $searchResult->setRelevance(1);
            $searchResults[] = $searchResult;
        }
        return $searchResults;
    }

    // }}} 
}

?>
