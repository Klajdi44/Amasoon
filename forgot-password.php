<?php
include_once(__DIR__ . '/components/top.php');
?>
<h1>recover password</h1>


<form onsubmit="return false">

	<label for="">Enter email</label>
	<input type="email" name='user_email'>
	<button onclick="sendRecoveryEmail()">send</button>
</form>

<script>
	async function sendRecoveryEmail() {
		try {
			const formdata = new FormData(event.target.form);
			const request = await fetch('api/api-forgot-password.php', {
				method: "POST",
				body: formdata
			});

			const response = await request.
			text();
			console.log(response);

		} catch (error) {
			console.error(error.message)
		}
	}
</script>

<?php
include_once(__DIR__ . '/components/bottom.php');
?>