<?php
$_show_nav = true;
require_once(__DIR__ . '/components/top.php');
// $shopProducts = json_decode(file_get_contents(__DIR__ . '/partner-shops/shop.txt'), true);
?>
<!-- <?php
			foreach ($shopProducts as $product) {
				echo "<article class='shop-item'>
<h2>{$product['title_en']}</h2>
</article>";
			}
			?> -->


<section class="products__container">
	<article class="my__products"></article>

</section>

<script type="module">
	async function generateShops() {
		const outputElement = _dqs('.my__products');
		if (localStorage.shopProducts) {
			return _renderProducts(JSON.parse(localStorage.shopProducts), outputElement, true)
		}
		try {
			const request = await fetch('./bridges/generator.php');
			const response = await request.json();

			if (request.ok) {
				localStorage.shopProducts = JSON.stringify(response);
				_renderProducts(JSON.parse(localStorage.shopProducts), outputElement, true)
			}
		} catch (error) {
			console.error(error.message);
		}
	}
	generateShops();
</script>

<?php require_once('./components/bottom.php'); ?>