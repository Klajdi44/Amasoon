<?php
require_once(__DIR__ . '/private/globals.php');

_handle_loggedin_status();
$_show_nav = true;
$_documentTitle = 'Upload product';
require_once(__DIR__ . '/components/top.php');
$_icon_className = 'upload__product';
?>

<main class="signup__container auth__container  page-width">
	<?php require_once(__DIR__ . "/components/back-button.php") ?>
	<div class="signup__wrapper auth__wrapper">
		<form onsubmit="return false" class="auth__form signup__form">
			<h1 class="auth__form__title">Upload Product</h1>
			<p class="error"></p>
			<legend>
				<label for="upload__product__title"> Title</label>
				<small>e.g 16 inch Macbook pro</small>
				<input id="upload__product__title" class="upload__product__title input" name="title" type="text" placeholder=" ">
			</legend>
			<legend>
				<label for="upload__product__description">Description</label>
				<small>At least 10 characters long</small>
				<textarea id="upload__product__description" class="upload__product__description input" name="description" type="text" placeholder=" "> </textarea>
			</legend>
			<legend>
				<label for="upload__product__cateogry">Category</label>
				<select class="upload__product__category input" name="category" id="upload__product__cateogry">
					<option hidden value="electronics">Select category</option>
					<option value="electronics">Electronics</option>
					<option value="art">Art</option>
					<option value="music">Music</option>
					<option value="kitchenware">kitchenware</option>
				</select>
			</legend>
			<legend>
				<label for="upload__product__price">Price</label>
				<small>Must contain only numbers</small>
				<input id="upload__product__price" class="upload__product__price input" name="price" type="tel" placeholder=" ">
			</legend>
			<legend>
				<label for="upload__product__image">Image</label>
				<small>Max 5MB. Only png, jpg, and jpeg formats</small>
				<input id="upload__product__image" accept="image/png, image/jpg, image/jpeg" class="upload__product__image " name="image" type="file" placeholder=" ">
			</legend>
			<legend class="product__btn__container">
				<button class="primary__btn ">Upload product<span class="loader hidden">
						<i class="fas fa-circle-notch fa-spin"></i>
					</span></button>
			</legend>
		</form>
	</div>
</main>

<script type='module'>
	_dqs('.product__btn__container').onclick = uploadProduct;
	async function uploadProduct() {
		const infoElement = _dqs('.error');
		const form = _dqs('.auth__form');

		//**validation */
		const {
			fieldOk,
			info,
			element
		} = _validateProductFields(form);

		if (!fieldOk) {
			_focus(element);
			return infoElement.textContent = info;
		}

		try {
			const request = await fetch("./api/api_upload_product.php", {
				method: "POST",
				body: new FormData(form)
			})

			const response = await request.json();
			infoElement.textContent = response?.info;
			if (request.ok) {
				infoElement.id = 'success';
				setTimeout(() => {
					infoElement.textContent = ''
					infoElement.id = '';
					form.reset();
				}, 1500);

			}
		} catch (error) {

		}
	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>