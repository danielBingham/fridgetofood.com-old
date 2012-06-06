<?php

/**
*
*/
class UserController extends Zend_Controller_Action {

    // {{{ indexAction():               public void

    public function indexAction()
    {
         $page = $this->getRequest()->getParam('page', 1);
         $order = $this->getRequest()->getParam('order', 'reputation');

    	$paginator = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_User_All($order));
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setDefaultItemCountPerPage(30);
        $this->view->paginator = $paginator;
    }

    // }}}
    // {{{ profileAction():             public void
    
    public function profileAction() {
    	$userID = $this->getRequest()->getParam('id', NULL);
        $tab = $this->getRequest()->getParam('tab', 'recipes'); 
        $page = $this->getRequest()->getParam('page', 1); 
        $order = $this->getRequest()->getParam('order', 'votes');

	
    	if($userID === NULL && !Zend_Auth::getInstance()->hasIdentity()) {
    		throw new Exception('You must provide an id in order to view a profile!');
    	} else if($userID === NULL && Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();    	
    	} else {
    		$user = Application_Model_Query_User::getInstance()->get($userID);
    	}
    	$this->view->user = $user;
        $this->view->tab = $tab;   
        
        $ribbons = array();
        foreach($user->getRibbons() as $ribbon) {
            if(!isset($ribbons[$ribbon->getType()])) {
                $ribbons[$ribbon->getType()] = array();
            }

            if(!isset($ribbons[$ribbon->getType()][$ribbon->getDisplayName()])) {
                $ribbons[$ribbon->getType()][$ribbon->getDisplayName()] = array();
                $ribbons[$ribbon->getType()][$ribbon->getDisplayName()]['count'] = 1;
                $ribbons[$ribbon->getType()][$ribbon->getDisplayName()]['ribbon'] = $ribbon;
            } else {
                $ribbons[$ribbon->getType()][$ribbon->getDisplayName()]['count']++;
            }
        }
        $this->view->ribbons = $ribbons;
 
        switch($tab) {	
            case 'recipes':
                $recipes = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_Recipe_PostedBy($user, $order));
                $recipes->setCurrentPageNumber($page);
                $recipes->setItemCountPerPage(6);
                $this->view->recipes = $recipes;
                break;
            case 'images':	
                $photos = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_Image_PostedBy($user, $order));
                $photos->setCurrentPageNumber($page);
                $photos->setItemCountPerPage(6);
                $this->view->photos = $photos;
                break;
        }	
    }

    // }}}
    // {{{ registerAction():            public void

    public function registerAction() {
        if(Zend_Auth::getInstance()->hasIdentity()) {
            throw new RuntimeException('We should not be here.');
        }

        if(!$this->getRequest()->isPost()) {
            return;
        }

        $translator = new Application_Service_Translator_User_Register();
        $user = new Application_Model_User();
        if(!$translator->translate($user, $this->getRequest()->getPost())) {
            $this->view->errors = $translator->getErrors();
            return;
        }


        Zend_Auth::getInstance()->getStorage()->write($user);
        return $this->_helper->redirector('index', 'index');
        
    }

    // }}}
    // {{{ editAction():                public void 
    
    public function editAction() {
    	if(!Zend_Auth::getInstance()->hasIdentity()) {
    		throw new RuntimeException('You must be logged in to edit your profile!');
    	}
   		$user = Zend_Auth::getInstance()->getIdentity(); 	
    	
    	if(!$this->getRequest()->isPost()) {
    		$this->view->user = $user;
    		return;
    	}
		
        $translator = new Application_Service_Translator_User_Edit();
		if(!$translator->translate($this->getRequest()->getPost(), $user)) {
			$this->view->user = $user;
            $this->view->errors = $translator->getErrors();
			return;
		}

		$persistor = new Application_Model_Persistor_User();
		$persistor->save($user);

        $ribbonHandler = new Application_Service_Ribbon_Handler();
        $ribbonHandler->checkAndGrant($user, 'autobiographer');		

        // TODO Gracefully handle image upload fail, especially as
        // caused by images that are too large. 
        $imageUploader = new Application_Service_ImageUploader();
        if($imageUploader->haveUpload() && !$imageUploader->upload()) {
            $this->view->user = $user; 
            $this->view->errors = array_merge((isset($this->errors) ? $this->errors : array()), array('image'=>$imageUploader->getErrors()));
            return;
        } else if($imageUploader->haveUpload()) {
            return $this->_helper->redirector('crop', 'photo', null, 
                array('image'=>$imageUploader->getImage()->getImageID(), 'user'=>$user->getUserID()));
        } else {
		    return $this->_helper->redirector('profile');
        }
    }

    // }}}
    // {{{ associateAction():           public void

    public function associateAction() {
       if(!Zend_Auth::getInstance()->hasIdentity()) {
            throw new RuntimeException('You must be logged in to associate social media accounts!');
        }

        $user = Zend_Auth::getInstance()->getIdentity();
        $which = $this->getRequest()->getParam('which', null);
        if($which == null) {
            return; 
        }     
   
        $code = $this->getRequest()->getParam('code', null);
        switch($which) {
            case 'facebook':
                $authService = new Application_Service_OAuth2_Facebook(); 
                $authService->authenticate($code);
                
                $user = $authService->getUser();
                if($user === null) {
                    $authService->associate(Zend_Auth::getInstance()->getIdenitity());        
                } else {
                    $mergeService = new Application_Service_User_Merge();
                    $mergeService->merge(Zend_Auth::getInstance()->getIdentity(), $user);
                }
                break;
            case 'google':
                $authService = new Application_Service_OAuth2_Google();
                $authService->authenticate($code); 

                $user = $authService->getUser();
                if($user === null) {
                    $authService->associate(Zend_Auth::getInstance()->getIdentity(), $user);    
                } else {
                    $mergeService = new Application_Service_User_Merge();
                    $mergeService->merge(Zend_Auth::getInstance()->getIdentity(), $user);
                }
                break;
            default:
                throw new RuntimeException('That is not a valid social media login source.');
        } 

    }

    // }}}
    // {{{ badgeAction():                   public void

    public function badgeAction() {
        if(!Zend_Auth::getInstance()->hasIdentity()) {
            return $this->_helper->redirector('index', 'login');
        }       
    }

    // }}}    

}

?>
