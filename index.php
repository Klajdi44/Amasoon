<?php
$_show_nav = true;
require_once(__DIR__ . '/components/top.php');
?>


<script>
	async function generateShops() {
		const request = await fetch('./bridges/generator.php');
		const response = await request.text();
	}
	generateShops();
</script>

<?php require_once('./components/bottom.php'); ?>