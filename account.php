<?php
require_once(__DIR__ . '/private/globals.php');
_handle_loggedin_status();
$_show_nav = true;
$_documentTitle = 'Account';

require_once(__DIR__ . '/components/top.php');
$_icon_className = 'account';
?>


<main class='account  page-width'>
	<?php require_once(__DIR__ . "/components/back-button.php") ?>
	<h1 class="account__title">Your Account</h1>

	<section class="account__body">
		<a href="./my-products" class='account__link'>
			<article class="card">
				<img src="./assets/your_items.png" alt="items" class='card__icon'>
				<span class='card__title__container'>
					<h2 class="card__title">My Products</h2>
					<p class='card__description'>View your products</p>
				</span>
			</article>
		</a>

		<a href="./edit-account" class='account__link'>
			<article class="card">
				<img src="./assets/edit__account.png" alt="items" class='card__icon'>
				<span class='card__title__container'>
					<h2 class="card__title">Login & Security</h2>
					<p class='card__description'>Edit login details</p>
				</span>
			</article>
		</a>
	</section>

</main>