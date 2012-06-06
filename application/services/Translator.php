<?php

/**
*
*
*/

abstract class Application_Service_Translator {

    public abstract function translate(array $post);

    public abstract function getResults();
    
    public abstract function getErrors();

}

?>
