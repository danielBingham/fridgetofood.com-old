<?php
class Zend_View_Helper_RenderRecipeBox extends Zend_View_Helper_Abstract {
	
	public function renderRecipeBox(Application_Model_Recipe $recipe) {
?>
		<div class="displayBox" <?php
					if($recipe->getPrimaryImage() !== NULL) {
						echo 'style="background-image: url(' . Zend_Registry::get('config')->hosts->image . '/medium/' . $recipe->getPrimaryImage()->getImageID() . '.jpg);"';
					} else {
						echo '';
					}
					?> >
			<a class=" boxLink" href="<?PHP echo $this->view->url(array('id'=>$recipe->getRecipeID(), 'url_title'=>$recipe->getURLTitle()), 'recipe'); ?>"></a>
			<div class="titleBox">
				<a href="/recipe/view/id/<?php echo $recipe->getRecipeID(); ?>">
					<?php  echo $recipe->getTitle(); ?>
				</a>
			</div>
			<div class="posterInfo">
				<p>recipe added by <a href="/user/profile/id/<?php echo $recipe->getUser()->getUserID(); ?>"><?php echo $recipe->getUser()->getDisplayName(); ?></a> (<?php echo $recipe->getUser()->getReputation(); ?> )</p>
			</div>
			<div class="left">
				<p class="leftText"><?php echo $recipe->getVoteTotal() ?></p>
				<span class="leftDescription">votes</span>
			</div>
			<div class="center">
				<p class="centerText"><?php echo $recipe->getViews() ?></p>
				<span class="centerDescription">views</span>
			</div>
			<div class="right">
				<p class="rightText"><?php echo $recipe->getNumberOfComments() ?></p>
				<span class="rightDescription">comments</span>
			</div>
		</div>
<?php
	}
	
}

?>
