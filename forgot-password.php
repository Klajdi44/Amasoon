<?php
include_once(__DIR__ . '/components/top.php');
?>

<section class="forgot__password__container">
	<?php require_once(__DIR__ . '/components/logo.php') ?>

	<p class="forgot__password__info error"></p>

	<article class="forgot__password ">

		<h1>Password assistance</h1>
		<p>Enter the email address associated with your Amasoon account.</p>


		<form onsubmit="return false">
			<label class="forgot__password__label" for="forgot__password__user__email">Email</label>
			<input class="forgot__password__user__email input" id="forgot__password_user_email" type="email" name='user_email'>
			<button class="primary__btn forgot__password__btn" onclick="sendRecoveryEmail()">Send <span class="loader hidden">
					<i class="fas fa-circle-notch fa-spin"></i>
				</span></button>
		</form>
	</article>
</section>

<script>
	async function sendRecoveryEmail() {
		try {
			const loader = document.querySelector('.loader ');
			loader.classList.remove("hidden");
			const formdata = new FormData(event.target.form);
			const infoElement = document.querySelector('.forgot__password__info')
			const request = await fetch('api/api-forgot-password.php', {
				method: "POST",
				body: formdata
			});

			const response = await request.
			json();
			console.log(response);
			document.querySelector('.forgot__password__info').textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';
			}
			loader.classList.add("hidden");

		} catch (error) {
			console.error(error.message)
		}
	}
</script>

<?php
include_once(__DIR__ . '/components/bottom.php');
?>