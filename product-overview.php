<?php
require_once(__DIR__ . '/private/globals.php');
$_show_nav = true;
$_documentTitle = $_GET['category'] ?? 'Products';
@require_once(__DIR__ . '/components/top.php');
?>
<main class='product__overview__container'>
	<section class="product__overview">
		<img class='product__overview__img' src="" alt="">
		<article class="product__overview__content">
			<div class="product__overview__body">
				<h2 class="product__overview__title"></h2>
				<h3 class="product__overview__price"></h3>
			</div>
			<p class="product__overview__description">Description </p>
		</article>
	</section>
</main>

<script type="module">
	(async function() {

		const title = _dqs('.product__overview__title');
		const price = _dqs('.product__overview__price');
		const description = _dqs('.product__overview__description');
		const img = _dqs('.product__overview__img');

		const formData = new FormData();
		if ('<?= $_GET['id'] ?>') {
			formData.append('id', '<?= $_GET['id'] ?>');
		}

		try {
			const request = await fetch('./api/api_product_overview.php', {
				method: "POST",
				body: formData
			});

			const response = await request.json();
			console.log(response);
			if (request.ok) {
				title.textContent = response.info.title;
				price.textContent = `Kr.${response.info.price}`;
				img.src = `./assets/${response.info.image}.jpeg`;
				description.textContent = response.info.description;

			}
		} catch (error) {
			console.error(error?.message);
		}
	})();
</script>
<?php require_once(__DIR__ . '/components/bottom.php'); ?>