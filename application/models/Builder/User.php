<?php
class Application_Model_Builder_User extends Application_Model_Builder_Abstract {
	
	public function __construct() {
		$this->_haveBuilt = array(
			'profileImage'=>false,
            'images'=>false,
			'recipes'=>false,
			'ribbons'=>false,
			'virtualAPI'=>false
		);
	}
	
	public function buildProfileImage(Application_Model_User $user) {
		if($user->getImageID()) {
			$user->setProfileImage(Application_Model_Query_Image::getInstance()->get($user->getImageID()));
		}
	}

    public function buildImages(Application_Model_user $user) {
        $user->setImages(Application_Model_Query_Image::getInstance()->fetchAll(array('user_id'=>$user->getUserID())));
    }
	
	public function buildRecipes(Application_Model_User $user) {
		$user->setRecipes(Application_Model_Query_Recipe::getInstance()->fetchAll(array('user_id'=>$user->getUserID())));
	}
	
	public function buildRibbons(Application_Model_User $user) {
		$user->setRibbons(Application_Model_Query_Ribbon::getInstance()->getRibbonsForUser($user));
	}
	
	public function buildVirtualAPI(Application_Model_User $user) {
		$mapper = new Application_Model_Mapper_User();
		$mapper->updateVirtualAPI($user);
	}
	
	public function buildAll(Application_Model_User $user) {
		$this->build('virtualAPI', $user);
		$this->build('image', $user);
	}
	
	
	
}
?>
