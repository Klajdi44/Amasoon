<?php
session_start();
if ($_SESSION['is_verified']) {
	header('Location: index');
}
?>

<?php require_once(__DIR__ . '/components/top.php') ?>
<section class="verify__email__container center">
	<article class="verify__email">
		<?php require_once(__DIR__ . '/components/logo.php') ?>
		<p class="verify__email__info error"></p>
		<p class="loader">Loading...</p>
	</article>
</section>


<script>
	verify_email();
	async function verify_email() {
		const formData = new FormData();
		const key = "<?= $_GET['key'] ?>";
		const loader = document.querySelector('.loader');
		const infoElement = document.querySelector('.verify__email__info');


		//validation
		if (!key || key?.length != 32) {
			loader.classList.add('hidden');
			return infoElement.textContent = "Suspicious...";
		}
		formData.append('key', key);

		try {
			const request = await fetch('api/api_verify_email.php', {
				method: "POST",
				body: formData
			});
			const response = await request.json();

			loader.classList.add('hidden');
			infoElement.textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';
				setTimeout(() => {
					window.location.href = "login";
				}, 4000);
			}

		} catch (error) {
			console.error(error.message)
		}

	}
</script>
<?php require_once(__DIR__ . '/components/bottom.php') ?>