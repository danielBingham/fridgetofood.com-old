<?php
/**
 * Override Zend_Paginator to allow for the user of
 * multiple paginators in the same action.
 */
class Application_Service_Paginator extends Zend_Paginator {
	private $_pageName = 'page';
	
	public function getPages($scrollingStyle = null) {
		$pages = parent::getPages($scrollingStyle);
		$pages->pageName = $this->_pageName;
		return $pages;
	}
	
	public function setPageName($pageName) {
		$this->_pageName = $pageName;
	}
}
?>