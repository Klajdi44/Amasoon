<?php
include_once(__DIR__ . '/private/globals.php');

if (!_is_user_signed_in()) {
	header('Location: index');
}
$_show_nav = true;
@require_once(__DIR__ . '/components/top.php');
$_title = 'Edit your current password';
@require_once(__DIR__ . '/components/password.php');
?>

<script type="module">
	dqs('.new__password__btn').onclick = editPassword;

	async function editPassword() {
		const infoElement = dqs('.new__password__info');
		const password = dqs('.user_password');
		const confirmPassword = dqs('.confirm_user_password');
		const formData = new FormData(event.target.form);

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
			let request = await fetch("api/api_edit_password", {
				method: "POST",
				body: formData
			})

			let response = await request.json();
			console.log(response);

			infoElement.textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';

				setTimeout(() => {
					window.location.href = "edit-account.php";
				}, 2500);
			}
		} catch (error) {
			console.error(error.message);
		}
	}
</script>

<?php require_once(__DIR__ . '/components/bottom.php') ?>