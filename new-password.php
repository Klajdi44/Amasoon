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
				<input id="user_password" class="user_password" name="user_password" type="password" placeholder=" ">
			</legend>

			<legend>
				<label for="re-enter_user_password">Confirm password</label>
				<small>Must match password above</small>
				<input id="confirm_user_password" class="re-enter_user_password" name="re-enter_user_password" type="password" placeholder=" ">
			</legend>

			<button class="new__password__btn primary__btn" onclick="createNewPassword()">Create</button>
		</form>
	</article>
</section>


<script>
	async function createNewPassword() {
		const infoElement = document.querySelector('.new__password__info');

		const urlParams = new URLSearchParams(window.location.search);

		const key = urlParams.has('key') ? urlParams.get('key') : null;
		const formData = new FormData(event.target.form)
		formData.append('key', key);

		if (!key || key?.length != 32) {
			return infoElement.textContent = "Suspicious"
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
				infoElement.classList.add('success');
			}
		} catch (error) {
			console.error(error.message);
		}

	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>
<!-- TODO:style forgot password page like in amazon -->
<!-- TODO:style new password page like in amazon -->
<!-- TODO: if email sent successfully then show that (maybe redirect users or show options to redirect)-->
<!-- TODO: if password changed successfully then show that and display options for redirecting-->