<?php
class Zend_View_Helper_RenderUserRibbons extends Zend_View_Helper_Abstract {

    // {{{ renderUserRibbons(Application_Model_User $user):                                         public string	

	public function renderUserRibbons(Application_Model_User $user) {
		$ribbons = array();
		foreach($user->getRibbons() as $ribbon) {
			$ribbons[$ribbon->getType()] = (array_key_exists($ribbon->getType(), $ribbons) ? $ribbons[$ribbon->getType()]+1 : 1);
		}
		
		$output = '<div class="ribbonBar">';

        if(isset($ribbons['blue'])) {
            $output .= '<div class="ribbon"><span class="ribbonIcon blue"></span><span class="text">' . $ribbons['blue'] . '</span> </div>';
        }
        if(isset($ribbons['red'])) {
            $output .= '<div class="ribbon"><span class="ribbonIcon red"></span><span class="text">' . $ribbons['red'] . '</span> </div>';
        }
        if(isset($ribbons['white'])) {
            $output .= '<div class="ribbon"><span class="ribbonIcon white"></span><span class="text">' . $ribbons['white'] . '</span> </div>';
        }
        if(isset($ribbons['rainbow'])) {
            $output .= '<div class="ribbon"><span class="ribbonIcon rainbow"></span><span class="text">' . $ribbons['rainbow'] . '</span> </div>';
        }
		
        $output .= '</div>';
        return $output;	
    }

    // }}}	
}

?>
