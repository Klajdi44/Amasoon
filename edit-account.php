<?php
$_show_nav = true;
$_documentTitle = 'Edit account';
require_once(__DIR__ . '/components/top.php');
require_once(__DIR__ . '/private/globals.php');

_handle_loggedin_status();


$_icon_className = 'edit-account';
?>

<main class='edit__account  page-width'>
	<?php require_once(__DIR__ . '/./components/back-button.php') ?>
	<div class="edit__account__content__wrapper">
		<h2 class="edit__account__title">Name, Number & Email</h2>
		<p class="edit__account__error error"></p>
		<form id="form" onsubmit="return false" class="edit__account__container">
			<legend class="edit__account__field user_name">
				<label for="user_name">First name</label>
				<input id="user_name" class="user_name input" name="user_name" type="text" placeholder=" " value="<?= $_SESSION['user_name'] ?>">
			</legend>
			<legend class="edit__account__field user_name">
				<label for="user_last_name">Last name</label>
				<input id="user_last_name" class="user_last_name input" name="user_last_name" type="text" placeholder=" " value="<?= $_SESSION['user_last_name'] ?>">
			</legend>
			<legend class="edit__account__field user_email">
				<label for="user_email">Email</label>
				<input id="user_email" class="user_email input" name="user_email" type="text" placeholder=" " value="<?= $_SESSION['user_email'] ?>">
			</legend>
			<legend class="edit__account__field user_phone_number">
				<label for="user_phone_number">Phone number</label>
				<small>Only Danish numbers e.g 40636096</small>
				<input id="user_phone_number" class="user_phone_number input" name="user_phone_number" type="tel" placeholder=" " value="<?= $_SESSION['user_phone_number'] ?>">
			</legend>
			<button onclick="editAccountInfo()" class="primary__btn edit__account__save__btn" disabled>Save</button>
		</form>
	</div>

	<div class="edit__account__content__wrapper password__section">
		<h2 class="edit__account__title">Password</h2>

		<div class="edit__account__container">
			<section class="edit__account__field user_password">
				<article class="">
					<strong>Password</strong>
					<p>******</p>
				</article>
				<a href="./edit-password">
					<input type='button' class="secondary-button edit__account__edit__btn" value="Edit">
				</a>
			</section>
		</div>
	</div>
</main>


<script type="module">
	const infoElement = _dqs('.error');
	const form = _dqs('form');
	const saveBtn = _dqs('.edit__account__save__btn');
	_dqs('.input', true).forEach(input => input.oninput = enableSave);
	saveBtn.onclick = editAccountInfo;

	function enableSave() {
		if (form.user_name.value.trim() !== '<?= $_SESSION['user_name'] ?>' || form.user_last_name.value.trim() !== '<?= $_SESSION['user_last_name'] ?>' || form.user_phone_number.value.trim() !== '<?= $_SESSION['user_phone_number'] ?>' || form.user_email.value.trim() !== '<?= $_SESSION['user_email'] ?>') {
			return saveBtn.removeAttribute('disabled');
		}
		saveBtn.setAttribute('disabled', '');
	}

	async function editAccountInfo() {
		const formData = new FormData(event.target.form);

		const {
			fieldOk,
			info,
			element
		} = _validateFields(form, true);

		if (!fieldOk) {
			_focus(element);
			return infoElement.textContent = info;
		}

		try {
			formData.append('user_id', '<?= $_SESSION["user_id"] ?>');
			const request = await fetch('./api/api_edit_account', {
				method: 'POST',
				body: formData
			});
			const response = await request.json();
			infoElement.textContent = response?.info;
			if (request.ok) {
				infoElement.id = 'success';
				setTimeout(() => {
					window.location.reload();
				}, 1000);
			}
		} catch (error) {
			console.error(error.message);
		}
	}
</script>
<?php require_once(__DIR__ . '/components/bottom.php') ?>