<?php
class Zend_View_Helper_RenderItemPager extends Zend_View_Helper_Abstract {
	
	public function renderItemPager(Zend_Paginator $paginator, $itemRenderer) {
?>
	<div class="browser">
<?php
	foreach($paginator as $item) {
		$this->view->$itemRenderer($item);
	}
	echo $this->view->paginationControl($paginator,
                                    'Sliding',
                                    'pagination_controls.phtml');
?>
	</div>
<?php
		
		
	}
	
}

?>
