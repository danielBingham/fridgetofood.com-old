<?php
class Zend_View_Helper_RenderUserBox extends Zend_View_Helper_Abstract {
	
	public function renderUserBox(Application_Model_User $user) {
	?>
	<div class="displayBox" <?php if($user->getImageID()) { ?>style="background-image: url(<?PHP echo Zend_Registry::get('config')->hosts->image; ?>/medium/<?php echo $user->getImageID(); ?>.jpg)" <?php } ?>>
		<a class="boxLink" href="/user/profile/id/<?php echo $user->getUserID(); ?>"></a>

		<div class="titleBox">
			<a  href="/user/profile/id/<?php echo $user->getUserID(); ?>"><?php echo $user->getDisplayName(); ?></a><br>
		</div>

		<div class="left">
			<p class="leftText"><?php echo $user->getReputation(); ?></p>
			<span class="leftDescription">reputation</p>
		</div>
		<div class="center">
			<?php echo $this->view->renderUserRibbons($user); ?>
		</div>
		<div class="right">
			<p class="rightText"><?php echo $user->getRecipeCount(); ?></p>
			<span class="rightDescription">recipes</p>
		</div>
	</div>
	
	<?php	
	}
	
}

?>
