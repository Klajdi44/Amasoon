<?php
require_once(__DIR__ . '/components/top.php');
$_documentTitle = 'New password';
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
		const form = event.target.form;
		const formData = new FormData(form);

		//validation
		if (!key || key?.length != 32) {
			return infoElement.textContent = "Suspicious"
		}
		formData.append('key', key);

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
			let request = await fetch("api/api_new_password", {
				method: "POST",
				body: formData
			})

			let response = await request.json();


			infoElement.textContent = response?.info;

			if (request.ok) {
				infoElement.id = 'success';

				setTimeout(() => {
					window.location.href = "login";
				}, 2500);
			}
		} catch (error) {
			console.error(error.message);
		}

	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>