<?php

class Application_View_Helper_SocialMedia {

    // {{{ getFacebookLink($redirectURL = null):                            public string

    public function getFacebookLink($redirectURL = null) {
        if($redirectURL === null) {
            $redirectURL = $this->getHome() . '/login/facebook';
        } else {
            $redirectURL = $this->getHome() . $redirectURL;
        }
		return 'https://www.facebook.com/dialog/oauth?'
            . 'client_id=' . Zend_Registry::get('config')->oauth->facebook->clientID 
            . '&redirect_uri=' . $redirectURL
            . '&scope=email';
    }	

    // }}}
    // {{{ getGoogleLink($redirectURL = null):                              public string

    public function getGoogleLink($redirectURL = null) {
        if($redirectURL === null) {
            $redirectURL = $this->getHome() . '/login/google';
        } else {
            $redirectURL = $this->getHome() . $redirectURL;
        }

        return 'https://accounts.google.com/o/oauth2/auth?'
            . 'response_type=code'
            . '&client_id=' . Zend_Registry::get('config')->oauth->google->clientID
            . '&redirect_uri=' . $redirectURL
            . '&scope=https://www.googleapis.com/auth/userinfo.profile+https://www.googleapis.com/auth/userinfo.email';
    }

    // }}}
    // {{{ getHome():                                                       protected string
	
    protected function getHome() {
		return Zend_Registry::get('config')->hosts->home;
	}

    // }}}


}

?>
