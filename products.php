<?php
require_once(__DIR__ . '/private/globals.php');
_handle_loggedin_status();
$_show_nav = true;
$_documentTitle = 'MY Products';
@require_once(__DIR__ . '/components/top.php');
?>

<main class='my__products__container'>
	<p>Products available: <span class="my__products__length">0</span> </p>
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
			if (request.ok) {
				_dqs('.my__products__length').textContent = response.info.length ?? [];
				renderItems(response);
			}
		} catch (error) {
			console.error(error?.message);
		}
	})();


	function renderItems({
		info: products
	}) {
		const productContainer = _dqs('.my__products');

		products.forEach(product => {
			console.log(product);
			// <h2 class="my__product__title">${product.item_name}</h2>

			const bluePrint = `
	<article class="my__product__item"> 
	<a href='./edit-account.php?id=${product.item_id}' >
	<img class='my__product__img' src='./assets/${product.item_image_path}.jpeg' alt="product">
	<div class="my__product__body">
		<h2 class="my__product__title">${product.item_name}</h2>
		<h3 class="my__product__price">Dkk ${product.item_price}</h3>
	</div>
	</a>
</article>
`
			productContainer.insertAdjacentHTML("beforeend", bluePrint);
		})
	}
</script>
<?php require_once(__DIR__ . '/components/bottom.php'); ?>