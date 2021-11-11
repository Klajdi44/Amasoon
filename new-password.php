<?php
require_once(__DIR__ . '/components/top.php');
?>

<section class="new__password__container">
	<?php require_once(__DIR__ . '/components/logo.php') ?>

	<p class="new__password__info"></p>

	<article class="new__password ">
		<h1 class="new__password__title"> Create a new password! </h1>
		<form onsubmit="return false">
			<legend>
				<label for="user_password">Password</label>
				<small>At least 8 characters</small>
				<input minlength="8" maxlength="20" id="user_password" class="user_password" name="user_password" type="password" placeholder=" ">
			</legend>

			<legend>
				<label for="confirm_user_password">Confirm password</label>
				<small>Must match password above</small>
				<input minlength="8" maxlength="20" id="confirm_user_password" class="confirm_user_password" name="confirm_user_password" type="password" placeholder=" ">
			</legend>

			<button class="new__password__btn primary__btn" onclick="createNewPassword()">Create</button>
		</form>
	</article>
</section>


<script>
	async function createNewPassword() {
		<?php include_once(__DIR__ . "./private/globals.php") ?>
		const infoElement = document.querySelector('.new__password__info');
		const password = document.querySelector('.user_password');
		const confirmPassword = document.querySelector('.confirm_user_password');

		const urlParams = new URLSearchParams(window.location.search);

		const key = urlParams.has('key') ? urlParams.get('key') : null;
		const formData = new FormData(event.target.form)
		formData.append('key', key);

		//validation
		if (!key || key?.length != 32) {
			return infoElement.textContent = "Suspicious"
		}

		if (!password.value.length || !confirmPassword.value.length) {
			return infoElement.textContent = "Fields cannot be empty!"
		}

		if (password.value != confirmPassword.value) {
			return infoElement.textContent = "Passwords do not match!"
		}

		if (password.value.length < 8) {
			return infoElement.textContent = "Password has be at least 8 characters long"
		}
		if (password.value.length > 16) {
			return infoElement.textContent = "Password cannot be more that 16 characters"
		}

		if (password.value != confirmPassword.value) {
			return infoElement.textContent = "Passwords do not match!"
		}

		try {
			let request = await fetch("api/api_new_password", {
				method: "POST",
				body: formData
			})

			let response = await request.json();
			console.log(response);

			infoElement.textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';

				setTimeout(() => {
					window.location.href = "login";
				}, 2000);
			}
		} catch (error) {
			console.error(error.message);
		}

	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>