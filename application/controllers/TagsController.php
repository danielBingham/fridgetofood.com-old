<?php

class TagsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    // {{{ indexAction()

    public function indexAction() {
        $page = $this->getRequest()->getParam('page', 1);
        $type = $this->getRequest()->getParam('type', 'all');       
 
        $adapter = new Application_Service_Paginator_Adapter_Tag_Recipe_All($type);
    	$paginator = new Application_Service_Paginator($adapter);
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setItemCountPerPage(100);
        $this->view->paginator = $paginator;
    }

    // }}}
    // {{{ viewAction()
    
    public function viewAction() {
    	$tagID = $this->getRequest()->getParam('id', null);

    	if($tagID == null) {
    		throw new Exception('An id is required to view a single tag.');
    	}
    	
    	$page = $this->getRequest()->getParam('page', 1);
    	$order = $this->getRequest()->getParam('order', 'votes');
    	
    	$tag = Application_Model_Query_Tag::getInstance()->get($tagID);
    	$adapter = new Application_Service_Paginator_Adapter_Recipe_TaggedWith($tag, $order);
    	$paginator = new Application_Service_Paginator($adapter);
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setItemCountPerPage(30);
		
    	$this->view->paginator = $paginator;
    	$this->view->tag = $tag;
    	
    }

    // }}}

}

