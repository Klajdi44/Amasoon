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
<main class="homepage__main">
	<section class="category__container">
		<article class="category">
			<a href="">
				<h2>Electronics</h2>
				<img class="category__image" src="./assets/electronics.png" alt="Electronics">
			</a>
		</article>
	</section>


	<section class="products__container">
		<article class="my__products"></article>
	</section>
</main>
<script type="module">
	const apiInfo = [{
		path: './bridges/generator.php',
		outputElement: _dqs('.my__products'),
		localStorageName: 'shopProducts',
		renderFunc: _renderProducts
	}, {
		path: './api/api_test.php',
		outputElement: _dqs('.category__container'),
		localStorageName: 'categories',
		renderFunc: _renderCategories
	}]

	Promise.all(apiInfo.map(api => handleApiCall(api.path, api.outputElement, api.localStorageName, api.renderFunc)))

	async function handleApiCall(url, outputElement, localstorageName, renderFunc) {
		const date = Date.now();

		if (localStorage[localstorageName] && JSON.parse(localStorage[localstorageName])?.ttl > date) {
			return renderFunc(JSON.parse(localStorage[localstorageName])?.data, outputElement, true)
		}

		try {
			const request = await fetch(url);
			const response = await request.json();

			if (request.ok) {
				const localStorageData = {
					data: response,
					//30 min
					ttl: date + 30 * 6000
				}

				localStorage[localstorageName] = JSON.stringify(localStorageData);
				renderFunc(response, outputElement, true)
			}
		} catch (error) {
			console.error(error.message);
		}
	}

	// function setWith(ttl) {
	// 	console.log('hello');
	// 	const date = Date.now();
	// 	console.log(!!localStorage.shop && JSON.parse(localStorage.shop).ttl > date);
	// 	if (localStorage.shop && JSON.parse(localStorage.shop).ttl > date) {
	// 		return console.log('render');
	// 	}
	// 	alert('clear')

	// 	localStorage.shop = JSON.stringify({
	// 		items: [1, 2],
	// 		ttl: date + ttl
	// 	})
	// }
	// setWith(5000);
</script>

<?php require_once('./components/bottom.php'); ?>