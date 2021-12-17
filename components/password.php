<?php $_icon_className = 'edit-password'; ?>
<section class="new__password__container">
	<?php require_once(__DIR__ . '/back-button.php') ?>

	<?php $_show_logo && require_once(__DIR__ . '/logo.php') ?>

	<p class="new__password__info error"></p>

	<article class="new__password ">
		<h1 class="new__password__title"> <?= $_title ?> </h1>
		<form onsubmit="return false">
			<legend>
				<label for="user_password">Password</label>
				<small>At least 8 characters</small>
				<input id="user_password" class="user_password input" name="user_password" type="password" placeholder=" ">
			</legend>

			<legend>
				<label for="confirm_user_password">Confirm password</label>
				<small>Must match password above</small>
				<input id="confirm_user_password" class="confirm_user_password input" name="confirm_user_password" type="password" placeholder=" ">
			</legend>

			<button class="new__password__btn primary__btn">Create</button>
			<!-- <button class="new__password__btn primary__btn" onclick="createNewPassword()">Create</button> -->
		</form>
	</article>
</section>