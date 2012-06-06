<?php
/**     
 * Copyright:
 *		Copyright (C) 2009-2011 Daniel Bingham (http://www.theroadgoeson.com)
 *
 * License:
 *
 * This software is licensed under the MIT Open Source License which reads as
 * follows:
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
 * USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information see here: http://www.opensource.org/licenses/mit-license.php
 */

/**
* Controller to handle actions related to recipe manipulation.  This includes
* the main recipe browsing page, the recipe view page, the recipe submit page
* and the recipe edit page.
*/
class RecipeController extends Zend_Controller_Action
{

    // {{{ indexAction():               public void

    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page', 1);
        $order = $this->getRequest()->getParam('order', 'newest');

    	$paginator = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_Recipe_All($order));
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setDefaultItemCountPerPage(30);
        $this->view->paginator = $paginator;
    }

    // }}}
    // {{{ viewAction():                public void

    public function viewAction()
    {
        $recipeID = $this->getRequest()->getParam('id');
        $recipe = Application_Model_Query_Recipe::getInstance()->get($recipeID);
       
        $viewer = new Application_Service_Recipe_View();
        $viewer->view($recipe);
       
        if(Zend_Auth::getInstance()->hasIdentity() && Zend_Auth::getInstance()->getIdentity()->getUserID() != $recipe->getUserID()) {
            $voter = new Application_Service_Recipe_Vote();
            $vote = $voter->getVote(Zend_Auth::getInstance()->getIdentity(), $recipe);
            $this->view->vote = $vote; 
         }    
        
        if($recipe->getPrimaryImage()) {
            $this->view->canonicalImage = '/medium/' . $recipe->getPrimaryImage()->getImageID() . '.jpg';
        }        
        $this->view->title = $recipe->getTitle();
        $this->view->recipe = $recipe;
    }
    
    // }}}
    // {{{ editAction():                public void
   
    /**
    * Action to allow a user to add a recipe or edit a recipe.  This is the long
    * recipe add forum.  
    */ 
    public function editAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            return $this->_helper->redirector('index', 'login'); 
        }
     
        $id = $this->getRequest()->getParam('id', null);
 
        // If we have a recipe id then we're editing.  Grab the recipe that we
        // want to edit.  And while we're at it, grab the tags, too.  We'll 
        // need those later.
        if($id !== null) {
            $areEditting = true;
            $recipe = Application_Model_Query_Recipe::getInstance()->get($id);
            // If our user is not the submitter of this recipe, then they aren't allowed to
            // edit it.

            // FIXME: account for possible admin editting of recipes.   
            if(Zend_Auth::getInstance()->getIdentity()->getUserID() != $recipe->getUserID()
                && Zend_Auth::getInstance()->getIdentity()->getUserID() != 2) {
                return $this->_helper->redirector('view', 'recipe', null, array('id'=>$recipe->getRecipeID())); 
            }        
        } else {
            $areEditting = false;
            $recipe = new Application_Model_Recipe(false);
        } 
  
 	
        if($this->getRequest()->isPost()) {
       	    $translator = new Application_Service_Translator_Recipe_FullForm();
            if($translator->translate($recipe, $this->getRequest()->getPost())) {
                $persistor = new Application_Model_Persistor_Recipe();
                $persistor->clear($recipe);
                $persistor->save($recipe);
 
                $ribbonHandler = new Application_Service_Ribbon_Handler();               
                $ribbonHandler->checkAndGrant(Zend_Auth::getInstance()->getIdentity(), 'cook');
                $ribbonHandler->checkAndGrant(Zend_Auth::getInstance()->getIdentity(), 'chefdepartie');
                $ribbonHandler->checkAndGrant(Zend_Auth::getInstance()->getIdentity(), 'souschef');
                $ribbonHandler->checkAndGrant(Zend_Auth::getInstance()->getIdentity(), 'chefdecuisine');

                return $this->_helper->redirector('view', 'recipe', NULL, array('id'=>$recipe->getRecipeID())); 
            } 
        } 

        // If we are editing a recipe, then we need
        // to pull out the tags and put them in a format
        // that will fit in their text field.  We also
        // need to give the recipe we're editing to the view.
        if($areEditting) {
            $tags = $recipe->getTags();
            $tagText = '';
            foreach($tags as $tag) {
                $tagText .= $tag->getName() . ', ';
            }
           
            $this->view->tags = $tagText; 
            $this->view->recipe = $recipe;
        }
               
        $ingredientSections = array();
        $instructionSections = array(); 
      
        // If we're editting then we need to build the section arrays for
        // both ingredients and instructions.  These will be used in
        // the form when building the forms.  
        if($areEditting) { 
            $sections = $recipe->getRecipeSections();
            foreach($sections as $section) {
                if($section->getIngredientCount() > 0) {
                    $ingredientSections[] = $section;
                } 
                if($section->getInstructionCount() > 0) {
                    $instructionSections[] = $section;
                } 
            }
        }
        
        if(count($ingredientSections) == 0) {
            $ingredientSections[] = 'Main';
        }
        if(count($instructionSections) == 0) {
            $instructionSections[] = 'Main';
        }

        $this->view->ingredients = $ingredientSections;
        $this->view->instructions = $instructionSections;
    }

    // }}}
    // {{{ submitAction():              public void

    public function submitAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            return $this->_helper->redirector('index', 'login'); 
        }
       
        if($this->getRequest()->isPost()) {
            $recipe = new Application_Model_Recipe(false);
 
            $translator = new Application_Service_Translator_Recipe_ShortForm();
            if($translator->translate($recipe, $this->getRequest()->getPost())) {
                $persistor = new Application_Model_Persistor_Recipe();
                $persistor->save($recipe);
                return $this->_helper->redirector('edit', 'recipe', NULL, array('id'=>$recipe->getRecipeID()));
            } else {
                $this->view->errors = $translator->getErrors();
            }
        }
    }

    // }}}
    // {{{ deleteAction():              public void

    public function deleteAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
        
        $id = $this->getRequest()->getParam('id', null);
        if($id === null) {
            throw new RuntimeException('You must give an ID in order to delete a recipe.');
        }

        $recipe = Application_Model_Query_Recipe::getInstance()->get($id);
       
        // FIXME: Handle admin authentication and delete ability. 
        if(Zend_Auth::getInstance()->getIdentity()->getUserID() != $recipe->getUserID()) {
            return $this->_helper->redirector('view', 'recipe', null, array('id'=>$recipe->getRecipeID())); 
        }
        
        $persistor = new Application_Model_Persistor_Recipe();
        $persistor->delete($recipe);
        $this->_helper->redirector('index', 'recipe');
    }

    // }}}            
    // {{{ voteAction():                public void

    public function voteAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
 
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            throw new RuntimeException('You must be logged in in order to vote.');
        }
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $vote = $this->getRequest()->getParam('vote', null);
        if($vote === null) {
            throw new RuntimeException('A vote must be given in order to vote on a recipe.  Suspect attack attempt.');
        }

        $recipeID = $this->getRequest()->getParam('id', null);
        if($recipeID === null) {
            throw new RuntimeException('A recipeID must be given in order to vote on a recipe.');
        }
        $recipe = Application_Model_Query_Recipe::getInstance()->get($recipeID);
     
        $voter = new Application_Service_Recipe_Vote();
        switch($vote) {
            case 1:
                $voter->voteUp($user, $recipe);
                break;
            case -1:
                $voter->voteDown($user, $recipe);
                break;
            default:
                throw new RuntimeException('That is an invalid vote value.  Suspect attack attempt.');
                break;
        }
        
        echo $recipe->getVoteTotal(); 
    }

    // }}}
    // {{{ commentAction():             public void

    public function commentAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }

        if($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();

            $commenter = new Application_Service_Recipe_Comment();
            $commenter->comment(Zend_Auth::getInstance()->getIdentity(), $post['id'], $post['comment']);
            return $this->_helper->redirector('view', 'recipe', null, array('id'=>$post['id']));
        }

        throw new RuntimeException('We should never get here.  There must have been an error of some kind.');
    }

    // }}}
    // {{{ editCommentAction():         public void

    public function editCommentAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $action = $this->getRequest()->getParam('stage', null);
        if($action === null) {
            throw new RuntimeException('An action must be provided to edit a comment.  Suspect an attack.');
        }

        if(!$this->getRequest()->isPost()) {
            return;
        }

        $post = $this->getRequest()->getPost();
        $comment = Application_Model_Query_RecipeComment::getInstance()->get($post['id']);
        
        switch($action) {
            case 'get':
                echo $comment->getContent(); 
                return;
            case 'set':
                $comment->setContent($post['content']);
                $persistor = new Application_Model_Persistor_RecipeComment();
                $persistor->save($comment);
                echo $comment->getContent();       
                return;
            default:
                die('Action was: ' . $action);

        }
    }

    // }}}
    // {{{ deleteCommentAction():       public void
    
    public function deleteCommentAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        if(!$this->getRequest()->isPost()) {
            return; 
        }

        $post = $this->getRequest()->getPost();
        $comment = Application_Model_Query_RecipeComment::getInstance()->get($post['id']);

        $persistor = new Application_Model_Persistor_RecipeComment();
        $persistor->delete($comment);
        return; 
    }
    
    // }}}


}



