<?php
require_once(__DIR__ . '/components/top.php');
?>

<form onsubmit="return false">
	<legend>
		<label for="user_password">Password</label>
		<small>At least 8 characters</small>
		<input id="user_password" class="user_password" name="user_password" type="password" placeholder=" ">
	</legend>

	<legend>
		<label for="re-enter_user_password">Re-enter password</label>
		<small>Must match password above</small>
		<input id="re-enter_user_password" class="re-enter_user_password" name="re-enter_user_password" type="password" placeholder=" ">
	</legend>

	<button onclick="createNewPassword()">Create</button>
</form>

<script>
	async function createNewPassword() {
		const urlParams = new URLSearchParams(window.location.search);
		const key = urlParams.has('key') ? urlParams.get('key') : null;
		const formData = new FormData(event.target.form)
		formData.append('key', key);

		if (!key || key?.length != 32) {
			return console.log('suspicious');
		}

		try {
			let conn = await fetch("api/api_new_password", {
				method: "POST",
				body: formData
			})

			let res = await conn.json();
			console.log(res);

			// if (conn.ok) {
			// 	location.href = "index"
			// }
		} catch (error) {
			console.error(error.message);
		}

	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>