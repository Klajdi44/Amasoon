<?php
include_once(__DIR__ . '/components/top.php');
?>

<section class="forgot__password__container">
	<?php require_once(__DIR__ . '/components/logo.php') ?>

	<p class="forgot__password__info error"></p>

	<article class="forgot__password ">

		<h1 class="forgot__password__title">Password assistance</h1>
		<p>Enter the email address associated with your Amasoon account.</p>


		<form onsubmit="return false">
			<label class="forgot__password__label" for="forgot__password__user__email">Email</label>
			<input class="forgot__password__user__email input" id="forgot__password_user_email" type="email" name='user_email'>
			<button class="primary__btn forgot__password__btn">Send <span class="loader hidden">
					<i class="fas fa-circle-notch fa-spin"></i>
				</span></button>
		</form>
	</article>
</section>

<script type="module">
	_dqs('.forgot__password__btn').onclick = sendRecoveryEmail;

	async function sendRecoveryEmail() {
		const form = event.target.form;
		const infoElement = _dqs('.forgot__password__info')
		const formdata = new FormData(event.target.form);
		const loader = _dqs('.loader ');

		const {
			fieldOk,
			info,
			element
		} = _validateEmail(form);

		if (!fieldOk) {
			_focus(element);
			return infoElement.textContent = info;
		}

		loader.classList.remove("hidden");
		try {
			const request = await fetch('api/api_forgot_password.php', {
				method: "POST",
				body: formdata
			});

			const response = await request.
			json();
			console.log(response);
			_dqs('.forgot__password__info').textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';
				form.user_email.value = '';
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