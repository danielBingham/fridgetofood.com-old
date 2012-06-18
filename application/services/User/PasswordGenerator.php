<?PHP 

class Application_Service_User_PasswordGenerator {

    // {{{ generate():                                                      public string

    public function generate() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()-_=+{}';

        $length = 20;
        $password = '';
        for($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, 77)];
        }
        return $password; 
    }

    // }}}
}


?>
