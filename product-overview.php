<?php
require_once(__DIR__ . '/private/globals.php');
$_show_nav = true;
$_documentTitle = $_GET['category'] ?? 'Products';
require_once(__DIR__ . '/components/top.php');
?>
<main class='product__overview__container page-width'>



</main>

<script type="module">
	(async function() {
		const productContainer = _dqs('.product__overview__container');

		if (containsString('<?= $_GET["id"] ?>')) {
			const productId = '<?= $_GET["id"] ?>';
			const partnerShopProduct = JSON.parse(localStorage.shopProducts)?.data?.info.find(({
				id
			}) => id === productId);

			return _renderProductOverview(partnerShopProduct, productContainer, true);
		}
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
				_renderProductOverview(response.info, productContainer, false, '<?= $_SESSION["user_id"] ?>');
			}
		} catch (error) {
			console.error(error?.message);
		}
	})();
</script>
<?php require_once(__DIR__ . '/components/bottom.php'); ?>