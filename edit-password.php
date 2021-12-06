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
	_dqs('.new__password__btn').onclick = editPassword;

	async function editPassword() {
		const infoElement = _dqs('.new__password__info');
		const password = _dqs('.user_password');
		const confirmPassword = _dqs('.confirm_user_password');
		const form = event.target.form;
		const formData = new FormData(form);

		const {
			fieldOk,
			info,
			element
		} = _validatePassword(form);


		if (!fieldOk) {
			_focus(element);
			return infoElement.textContent = info;
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