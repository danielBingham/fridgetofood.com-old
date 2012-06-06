<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    
    }
    
    public function simpleAction() {
        $title = $this->getRequest()->getParam('t', null);
        $ingredients = $this->getRequest()->getParam('i', null);
        $tags = $this->getRequest()->getParam('tg', null);
       
        // For some reason, getParam() isn't detecting the empty parameters... 
        if(empty($tags)) {
            $tags = null;
        }
        if(empty($title)) {
            $title = null;
        }
        if(empty($ingredients)) {
            $ingredients = null;
        } 
         
 	
    	if($this->getRequest()->isGet() && ($title !== null || $ingredients !== null || $tags !== null)) {
            $order = $this->getRequest()->getParam('order', 'relevance');
            $page = $this->getRequest()->getParam('page', 1);
            
            $searchService = new Application_Service_Search_Simple();
            $search = $searchService->search($title, $ingredients, $tags);
            $this->view->paginator = new Application_Service_Paginator(new Application_Service_Paginator_Adapter_Recipe_Search($search, $order));	
            $this->view->paginator->setItemCountPerPage(6); 
            $this->view->paginator->setCurrentPageNumber($page);
            $this->view->search = $search;

        } else {
            $this->view->paginator = null;
        }
    }
    
    public function advancedAction() {}
    
    public function quickAction() {}


}

