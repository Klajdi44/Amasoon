<?php
require_once(__DIR__ . '/private/globals.php');
$_show_nav = true;
$_documentTitle = $_GET['category'] ?? 'Products';
@require_once(__DIR__ . '/components/top.php');
?>

<main class='products__container  page-width'>
	<p class="products__length__container">Total products: <span class="my__products__length">0</span> </p>
	<section class='my__products'>


	</section>

</main>

<script type="module">
	(async function() {
		const formData = new FormData();
		if ('<?= $_GET['category'] ?>') {
			formData.append('category', '<?= $_GET['category'] ?>');
		}

		try {
			const request = await fetch('./api/api_products.php', {
				method: "POST",
				body: formData
			});

			const response = await request.json();
			console.log(response);
			if (request.ok) {
				_dqs('.my__products__length').textContent = response.length ?? [];
				const productContainer = _dqs('.my__products');
				_renderProducts(response, productContainer)
			}
		} catch (error) {
			console.error(error?.message);
		}
	})();
</script>
<?php require_once(__DIR__ . '/components/bottom.php'); ?>