<?php
@require_once(__DIR__ . '/private/globals.php');
_handle_loggedin_status();
$_show_nav = true;
$_documentTitle = 'Account';
@require_once(__DIR__ . '/components/top.php');
?>


<main class='account'>

	<h1 class="account__title">Your Account</h1>

	<section class="account__body">
		<a href="#" class='account__link'>
			<article class="card">
				<img src="./assets/your_items.png" alt="items" class='card__icon'>
				<span class='card__title__container'>
					<h2 class="card__title">Uploaded Items</h2>
					<p class='card__description'>View your uploaded items</p>
				</span>
			</article>
		</a>

		<a href="./edit-account.php" class='account__link'>
			<article class="card">
				<img src="./assets/edit__account.png" alt="items" class='card__icon'>
				<span class='card__title__container'>
					<h2 class="card__title">Login & Security</h2>
					<p class='card__description'>Edit login details</p>
				</span>
			</article>
		</a>

		<a href="#" class='account__link'>
			<article class="card">
				<img src="./assets/your_items.png" alt="items" class='card__icon'>
				<span class='card__title__container'>
					<h2 class="card__title">Your Items</h2>
					<p class='card__description'>See your uploaded items</p>
				</span>
			</article>
		</a>
	</section>

</main>