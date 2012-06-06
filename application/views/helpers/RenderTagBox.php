<?php
class Zend_View_Helper_RenderTagBox extends Zend_View_Helper_Abstract {
	
	public function renderTagBox(Application_Model_Tag $tag) {
?>
		<div class="tagWrapper">
			<a href="/tags/view/<?php echo $tag->getTagID(); ?>" class="tag <?php echo $tag->getType(); ?>"><?php echo $tag->getName(); ?></a>
			 <?php echo $tag->getType(); ?> tag with <?php echo $tag->getRecipeCount(); ?> recipes
		</div>
<?php
	}
	
}

?>
