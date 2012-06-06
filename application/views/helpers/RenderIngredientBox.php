<?php
class Zend_View_Helper_RenderIngredientBox extends Zend_View_Helper_Abstract {
	
	public function renderIngredientBox(Application_Model_Ingredient $ingredient) {
?>
		<div class="displayBox" >
			<a class="boxLink" href="/ingredient/view/id/<?php echo $ingredient->getIngredientID(); ?>"></a>
			<div class="titleBox">
				<a href="/ingredient/view/id/<?php echo $ingredient->getIngredientID(); ?>">
					<?php  echo $ingredient->getName(); ?>
				</a>
			</div>
			<div class="left">
				<p class="leftText"></p>
				<span class="leftDescription"></span>
			</div>
			<div class="center">
				<p class="centerText"><?php echo $ingredient->getRecipeCount(); ?></p>
				<span class="centerDescription">recipes</span>
			</div>
			<div class="right">
				<p class="rightText"></p>
				<span class="rightDescription"></span>
			</div>
		</div>
<?php	
	}
	
}

?>