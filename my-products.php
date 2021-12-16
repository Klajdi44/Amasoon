<?php
require_once(__DIR__ . '/private/globals.php');
_handle_loggedin_status();
$_show_nav = true;
$_documentTitle = 'My Products';
require_once(__DIR__ . '/components/top.php');
?>

<main class='products__container  page-width'>
	<?php require_once(__DIR__ . '/./components/back-button.php') ?>
	<p class="my__products__length__container">My products: <span class="my__products__length">0</span> </p>
	<section class='my__products'>


	</section>

</main>

<script>
	(async function() {
		const formData = new FormData();
		formData.append('user_id', '<?= $_SESSION['user_id'] ?>');
		try {
			const request = await fetch('./api/api_my_products.php', {
				method: "POST",
				body: formData
			});

			const response = await request.json();
			console.log(response);
			if (request.ok) {
				_dqs('.my__products__length').textContent = response.info.length ?? [];
				const productContainer = _dqs('.my__products');
				_renderProducts(response.info, productContainer)
			}
		} catch (error) {
			console.error(error?.message);
		}
	})();
</script>
<?php require_once(__DIR__ . '/components/bottom.php'); ?>