<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->_forward('index', 'recipe', null, $this->getRequest()->getParams());
    }

}

