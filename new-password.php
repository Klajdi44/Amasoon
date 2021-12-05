<?php
require_once(__DIR__ . '/components/top.php');
$_title = 'Create a new password!';
$_show_logo = true;
require_once(__DIR__ . '/components/password.php');
?>

<script type="module">
	_dqs('.new__password__btn').onclick = createNewPassword;

	async function createNewPassword() {
		const infoElement = _dqs('.new__password__info');
		const password = _dqs('.user_password');
		const confirmPassword = _dqs('.confirm_user_password');
		const key = "<?= $_GET['key'] ?>"
		const formData = new FormData(event.target.form)

		//validation
		if (!key || key?.length != 32) {
			return infoElement.textContent = "Suspicious"
		}
		formData.append('key', key);

		if (!password.value.length || !confirmPassword.value.length) {
			return infoElement.textContent = "Fields cannot be empty!"
		}

		if (password.value != confirmPassword.value) {
			return infoElement.textContent = "Passwords do not match!"
		}

		if (password.value.length < _PASSWORD_MIN_LEN) {
			return infoElement.textContent = "Password has be at least 8 characters long"
		}
		if (password.value.length > _PASSWORD_MAX_LEN) {
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
				}, 4000);
			}
		} catch (error) {
			console.error(error.message);
		}

	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>