<?php
$_show_nav = true;
include_once(__DIR__ . '/components/top.php');
include_once(__DIR__ . '/private/globals.php');

if (!_is_user_signed_in()) {
	header('Location: index');
}

?>

<main class='edit__account'>
	<div class="edit__account__content__wrapper">
		<h2 class="edit__account__title">Login & Security</h2>
		<div class="edit__account__container">
			<section class="edit__account__field user_name">
				<article class="">
					<strong>Name</strong>
					<p><?= $_SESSION['user_name'] ?> </p>
				</article>
				<button class="secondary-button edit__account__edit__btn">Edit</button>
			</section>
			<section class="edit__account__field user_email">
				<article>
					<strong>Email</strong>
					<p><?= $_SESSION['user_email'] ?> </p>
				</article>
				<button class="secondary-button edit__account__edit__btn">Edit</button>
			</section>
			<section class="edit__account__field user_phone_number">
				<article class="">
					<strong>Phone number</strong>
					<p><?= $_SESSION['user_phone_number'] ?> </p>
				</article>
				<button class="secondary-button edit__account__edit__btn">Edit</button>
			</section>
			<section class="edit__account__field user_password">
				<article class="">
					<strong>Password</strong>
					<p>******</p>
				</article>
				<button class="secondary-button edit__account__edit__btn">Edit</button>
			</section>
		</div>
	</div>
</main>