<?php
class Zend_View_Helper_RenderUserControls extends Zend_View_Helper_Abstract {
	
	private $_user;

    // {{{ getUser():                                                       public Application_Model_User
	
	public function getUser() {
		if(!$this->_user) {
			if(Zend_Auth::getInstance()->hasIdentity()) {
				$this->_user = Zend_Auth::getInstance()->getIdentity();
			} else {
				$this->_user = NULL;
			}
		}
		return $this->_user;
	}

    // }}}

    // {{{ getHome():                                                       public string
	
    public function getHome() {
		return Zend_Registry::get('config')->hosts->home; 
	}

    // }}}
    // {{{ renderUserControls():                                            public void (echos HTML)	
    // FIXME: This should return instead of echoing.
	public function renderUserControls() {
        $helper = new Application_View_Helper_SocialMedia();	

    	if($this->getUser()) {
		    $output =  '<span class="menuItem">' 
			. '     <a href="/user/profile/id/' . $this->getUser()->getUserID() . '">' . $this->getUser()->getDisplayName() . '</a>' 
			. '</span> '
			. ' <span class="menuItem"><a href="/login/logout">Logout</a></span> ';

		} else {
            $output = '<a href="/login/index">Login</a>: '
			. '<a href="' . $this->getHome() . '/login/"> '
            . ' <img src="/fridge.ico" />' 
            . '</a> '
			. '<a href="' . $helper->getFacebookLink() . '" ><img src="/img/facebook_16.png" /></a> '
			. '<a href="' . $helper->getGoogleLink() . '" ><img src="/img/google_16.png" /></a> ';
		}

        return $output;		
	}

    // }}}
	
}
?>
