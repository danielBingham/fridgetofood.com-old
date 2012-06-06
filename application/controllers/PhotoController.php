<?php

class PhotoController extends Zend_Controller_Action
{

    // {{{ init():                                                          public void

    public function init()
    {
        /* Initialize action controller here */
    }

    // }}}
    // {{{ indexAction()

    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page', 1);
        $order = $this->getRequest()->getParam('order', 'newest');

        $adapter = new Application_Service_Paginator_Adapter_Image_Recipe_All($order);
     	$paginator = new Application_Service_Paginator($adapter);
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setItemCountPerPage(30);
        $this->view->paginator = $paginator;
    }

    // }}}
    // {{{ viewAction()
    
    public function viewAction() {
    	$imageID = $this->getRequest()->getParam('id', NULL);
    	if($imageID === NULL) {
    		throw new Exception('An image ID is required to view an image.');
    	}
    	
    	$image = Application_Model_Query_Image::getInstance()->get($imageID);
        
        $persistor = new Application_Model_Persistor_Image();
        $image->setViews($image->getViews()+1);
        $persistor->save($image); 

      	$this->view->image = $image;
   
        if(Zend_Auth::getInstance()->hasIdentity()) { 
            $voter = new Application_Service_Image_Vote();
            $this->view->vote = $voter->getVote(Zend_Auth::getInstance()->getIdentity(), $image);
        }
    	
    	$paginator = new Application_Service_Paginator_Image_OneByOne(new Application_Service_Paginator_Adapter_Image_ForRecipe($image->getRecipe()));
    	$paginator->setCurrentPageNumber($paginator->getPageForItem($image));
    	$this->view->paginator = $paginator;
    }
   
    // }}}
    // {{{ galleryAction()
  
    public function galleryAction() {
    	$recipeID = $this->getRequest()->getParam('id', NULL);
    	$page = $this->getRequest()->getParam('page', 1);
    	
    	if($recipeID === NULL) {
    		throw new Exception('A recipe ID is required to view a gallery of photographs for a particular recipe.');
    	}
    	
    	$recipe =  Application_Model_Query_Recipe::getInstance()->get($recipeID);
    	
    	$paginator = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_Image_ForRecipe($recipe));
    	$paginator->setItemCountPerPage(30);
    	$paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $paginator;
    	$this->view->recipe = $recipe;
    }
    
    // }}}
    // {{{ addAction()
    
    public function addAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            return $this->_helper->redirector('index', 'login');
        } 

        $recipe = $this->getRequest()->getParam('recipe', null);
        if($recipe === null) {
            throw new RuntimeException('You must provide the id of the recipe you wish to upload to.');
        }
        
        $this->view->recipeID = $recipe;
        // TODO Gracefully handle image upload fail, especially as
        // caused by images that are too large. 
        $imageUploader = new Application_Service_ImageUploader();
        if($imageUploader->haveUpload() && !$imageUploader->upload()) {
            $this->errors = $imageUploader->getErrors();
            return;
        } else if($imageUploader->haveUpload()) {
            return $this->_helper->redirector('crop', 'photo', null, 
                array('image'=>$imageUploader->getImage()->getImageID(), 'recipe'=>$recipe));
        }
    }

    // }}}
    // {{{ cropAction()
    
    public function cropAction() {
        $this->view->js = array('crop');

        $imageID = $this->getRequest()->getParam('image', null);
        if($imageID === null) {
            throw new RuntimeException('We need an image to crop!');
        }

        $recipeID = $this->getRequest()->getParam('recipe', null);
        $userID = $this->getRequest()->getParam('user', null);
        if($recipeID === null && $userID === null) {
            throw new RuntimeException('We need something to attach the cropped image to!'); 
        } else if($recipeID !== null) {
            $image = Application_Model_Query_Image::getInstance()->get($imageID);
            $recipe = Application_Model_Query_Recipe::getInstance()->get($recipeID);

            if($this->getRequest()->isPost()) {
                $imageUploader = new Application_Service_ImageUploader();
                $imageUploader->crop($image, $this->getRequest()->getPost());
             
                $recipe->setImages(array_merge(array($image), $recipe->getImages())); 
                 
                $persistor = new Application_Model_Persistor_Recipe();
                $persistor->save($recipe);
     
                return $this->_helper->redirector('view', 'photo', null, array('id'=>$image->getImageID()));
            }

            $this->view->image = $image;
            $this->view->recipe = $recipe; 
        } else if($userID !== null && Zend_Auth::getInstance()->hasIdentity() && Zend_Auth::getInstance()->getIdentity()->getUserID() == $userID) {
            $image = Application_Model_Query_Image::getInstance()->get($imageID);
            $user = Application_Model_Query_User::getInstance()->get($userID);
            $user->setPassword(null); // FIXME This is a hack fix.

            if($this->getRequest()->isPost()) {
                $imageUploader = new Application_Service_ImageUploader();
                $imageUploader->crop($image, $this->getRequest()->getPost());
             
                $user->setProfileImage($image);                
 
                $persistor = new Application_Model_Persistor_User();
                $persistor->save($user);
     
                return $this->_helper->redirector('profile', 'user'); 
            }

            $this->view->image = $image;
            $this->view->user = $user; 
        }
    }

    // }}}
    // {{{ voteAction() 
    
    public function voteAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
 
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            throw new RuntimeException('You must be logged in in order to vote.');
        }
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $vote = $this->getRequest()->getParam('vote', null);
        if($vote === null) {
            throw new RuntimeException('A vote must be given in order to vote on an image.  Suspect attack attempt.');
        }

        $imageID = $this->getRequest()->getParam('id', null);
        if($imageID === null) {
            throw new RuntimeException('A recipeID must be given in order to vote on a recipe.');
        }
        $image = Application_Model_Query_Image::getInstance()->get($imageID);
     
        $voter = new Application_Service_Image_Vote();
        switch($vote) {
            case 1:
                $voter->voteUp($user, $image);
                break;
            case -1:
                $voter->voteDown($user, $image);
                break;
            default:
                throw new RuntimeException('That is an invalid vote value.  Suspect attack attempt.');
                break;
        }
        
        echo $image->getVotes(); 

    }

    // }}}

}

?>
