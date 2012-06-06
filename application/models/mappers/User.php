<?php
class Application_Model_Mapper_User {
	private $_dbTable;

    // {{{ updateVirtualAPI(Application_Model_User $user):                  public void
	
	public function updateVirtualAPI(Application_Model_User $user) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$results = $db->fetchAll('select count(id) as recipe_count from recipes where user_id=?', $user->getUserID());

		if(!empty($results)) {
			$user->setRecipeCount($results[0]['recipe_count']);
		} else {
			$user->setRecipeCount(0);
		}
	}

    // }}}
    // {{{ setPassword($user, $password):                                   public void
	
	public function setPassword($user, $password) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->query('update users set password=md5(?) where id=?', array($password, $user->getUserID()));
	}

    // }}}
    // {{{ mergeAssociations(Application_Model_User $into, Application_Model_User $from):             public void
    
    public function mergeAssociations(Application_Model_User $into, Application_Model_User $from) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array ('user_id'=>$into->getUserID());
 
        $db->update('user_facebooks', $data, $db->quoteInto('user_id=?', $from->getUserID()));
        $db->update('user_googles', $data, $db->quoteInto('user_id=?', $from->getUserID()));
    }

    // }}}	
    // {{{ mergeReputation(Application_Model_User $into, Application_Model_User $from):             public void
    
    public function mergeReputation(Application_Model_User $into, Application_Model_User $from) {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $data = array ('user_id'=>$into->getUserID());
 
        $db->update('reputation_bonuses', $data, $db->quoteInto('user_id=?', $from->getUserID()));
    }

    // }}}	
    
    // Standard mapper API
    // {{{ getDbTable():                                                    public Application_Model_DbTable_User
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_User();
		}
		return $this->_dbTable;
	}

    // }}}
    // {{{ fromDbObject(Application_Model_User $user, $data):               public void 

	public function fromDbObject(Application_Model_User $user, $data) {
		$this->fromDbArray($user, $data->toArray());
	}

    // }}}
    // {{{ fromDbArray(Application_Model_User $user, array $data):          public void
	
	public function fromDbArray(Application_Model_User $user, array $data) {

		$user->setUserID($data['id'])
			->setEmail(stripslashes($data['email']))
			->setPassword($data['password'])
			->setDisplayName(stripslashes($data['display_name']))
			->setReputation($data['reputation'])
			->setWebsite(stripslashes($data['website']))
			->setWebsiteURL(stripslashes($data['website_url']))
			->setBlogImport(($data['import_blog'] == 1 ? true : false))
			->setAbout(stripslashes($data['about']))
			->setImageID($data['image_id'])
			->setCreated(new Zend_Date($data['created'], Zend_Date::ISO_8601))
			->setSeen(new Zend_Date($data['seen'], Zend_Date::ISO_8601))
			->setNotified(new Zend_date($data['notified'], Zend_Date::ISO_8601))
			->setModified(new Zend_Date($data['modified'], Zend_Date::ISO_8601));
	}

    // }}}	
    // {{{ toDbArray(Application_Model_User $user):                         public array
	
	public function toDbArray(Application_Model_User $user) {
		$data = array(
			'email'=>$user->getEmail(),
			'display_name'=>$user->getDisplayName(),
			'website'=>$user->getWebsite(),
			'website_url'=>$user->getWebsiteURL(),
			'import_blog'=>($user->wantsBlogImport() ? 1 : 0),
			'about'=>$user->getAbout(),
			'image_id'=>$user->getImageID(),
		);
		
		if($user->getCreated()) {
			$data['created'] = $user->getCreated()->toString('yyyy-MM-dd HH:mm:ss');
		}
		
		if($user->getModified()) {
			$data['modified'] = $user->getModified()->toString('yyyy-MM-dd HH:mm:ss');
		}
		
		if($user->getNotified()) {
			$data['notified'] = $user->getNotified()->toString('yyyy-MM-dd HH:mm:ss');
		}
		
		if($user->getSeen()) {
			$data['seen'] = $user->getSeen()->toString('yyyy-MM-dd HH:mm:ss');
		}
		
		return $data;
	}

    // }}}

}
?>
