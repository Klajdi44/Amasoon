<?php
$_documentTitle = "Home";
$_show_nav = true;
$_className = 'index__body';
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
<main class="homepage__main page-width">
	<section class="category__container">
		<article id="category__all" class="category">
			<a href='./products.php'>
				<h2>All Categories</h2>
				<img class="category__image" src="./assets/all-categories.png" alt="Electronics">
			</a>
		</article>
	</section>


	<section class="partner__products__container">
		<h1 class="partner__products__title">Products from partners</h1>
		<article class="my__products"></article>
	</section>
</main>

<script type="module">
	const apiInfo = [{
		path: './api/api_shop_generator.php',
		outputElement: _dqs('.my__products'),
		localStorageName: 'shopProducts',
		renderFunc: _renderProducts,
		isCategory: false
	}, {
		path: './api/api_categories.php',
		outputElement: _dqs('.category__container'),
		localStorageName: 'categories',
		renderFunc: _renderCategories,
		isCategory: true
	}]

	Promise.all(apiInfo.map(api => handleApiCall(api)))

	async function handleApiCall({
		path,
		outputElement,
		localStorageName,
		renderFunc,
		isCategory
	}) {
		const date = Date.now();

		if (localStorage[localStorageName] && JSON.parse(localStorage[localStorageName])?.ttl > date) {
			return renderFunc.apply(null, isCategory ? [JSON.parse(localStorage[localStorageName]).data.info, outputElement] : [JSON.parse(localStorage[localStorageName]).data.info, outputElement, true])
		}

		try {
			const request = await fetch(path);
			const response = await request.json();

			if (request.ok) {
				const localStorageData = {
					data: response,
					//30 min
					ttl: date + 30 * 60000
				}

				localStorage[localStorageName] = JSON.stringify(localStorageData);

				renderFunc.apply(null,
					isCategory ? [response.info, outputElement] : [response.info, outputElement, true]
				)
			}
		} catch (error) {
			console.error(error.message);
		}
	}
</script>

<?php require_once('./components/bottom.php'); ?>