<?php
class Zend_View_Helper_RenderImageBox extends Zend_View_Helper_Abstract {
	
	public function renderImageBox(Application_Model_Image $image) {
?>
		<div class="displayBox"<?php
					if($image->fileExists()) {
						echo 'style="background-image: url(' . Zend_Registry::get('config')->hosts->image . '/medium/' . $image->getImageID() . '.jpg);"';
					}
					?>  >
			<a class="boxLink" href="/photograph/<?php echo $image->getImageID(); ?>"></a>
			<div class="titleBox">
				<a href="/photograph/<?php echo $image->getImageID(); ?>">
					<?php  echo $image->getRecipe()->getTitle(); ?>
				</a>
			</div>
			<div class="left">
				<p class="leftText"><?php echo $image->getVotes(); ?></p>
				<span class="leftDescription">votes</span>
			</div>
			<div class="center">
				<p class="centerText"><?php echo $image->getViews(); ?></p>
				<span class="centerDescription">views</span>
			</div>
			<div class="right">
				<p class="rightText">0</p>
				<span class="rightDescription">comments</span>
			</div>
		</div>
<?php	
	}
	
}

?>
