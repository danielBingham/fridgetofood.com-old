<?php
/**
*
*/
class Application_Service_OAuth_Twitter {
    private $CONSUMER_KEY = 'PUWLz79iPikiNx77OQmLSA';
    private $CONSUMER_SECRET = 'TjqK0jdIGsuHkSlkIypNO1wfGpBHASos6fCEvip0';

    // {{{ getToken():                                                      protected void

    protected function getToken() {
        $url = 'https://api.twitter.com/oauth/request_token';
        $params['oauth_version'] = '1.0';
        $params['oauth_nonce'] = mt_rand();
        $params['oauth_timestamp'] = time();
        $params['oauth_consumer_key'] = $CONSUMER_KEY;
        $params['oauth_callback'] = 'http://www.fridgetofood.com/login/twitter/';
        $params['oauth_signature_method'] = 'PLAINTEXT';
        $params['oauth_signature'] = $CONSUMER_SECRET&null;       


        $connection = curl_init();
    
    

    }

    // }}}
}
?>
