<?php
session_start();
if ($_GET['id'] !== $_SESSION['last_product']['id']) {
	header('location: ./products');
}
require_once(__DIR__ . '/private/globals.php');
_handle_loggedin_status();

$_show_nav = true;
$_documentTitle = 'Edit product';
require_once(__DIR__ . '/components/top.php');

$_icon_className = 'edit-product';
?>

<main class="signup__container auth__container  page-width">
	<?php require_once(__DIR__ . '/./components/back-button.php') ?>
	<div class="signup__wrapper auth__wrapper">
		<form onsubmit="return false" class="auth__form signup__form">
			<h1 class="auth__form__title">Edit Product</h1>
			<p class="error"></p>
			<legend>
				<label for="upload__product__title"> Title</label>
				<small>e.g 16 inch Macbook pro</small>
				<input id="upload__product__title" class="upload__product__title input" name="title" type="text" value="<?= $_SESSION['last_product']['title'] ?>" placeholder=" ">
			</legend>
			<legend>
				<label for="upload__product__description">Description</label>
				<small>At least 10 characters long</small>
				<textarea id="upload__product__description" class="upload__product__description input" name="description" type="text" placeholder=" "><?= $_SESSION['last_product']['description'] ?> </textarea>
			</legend>
			<legend>
				<label for="upload__product__cateogry">Category</label>
				<select class="upload__product__category input" name="category" id="upload__product__cateogry">
					<option hidden value="">Select category</option>
					<option value="electronics">Electronics</option>
					<option value="art">Art</option>
					<option value="music">Music</option>
					<option value="kitchenware">kitchenware</option>
				</select>
			</legend>
			<legend>
				<label for="upload__product__price">Price</label>
				<small>Must contain only numbers</small>
				<input id="upload__product__price" class="upload__product__price input" name="price" type="tel" placeholder=" " value="<?= $_SESSION['last_product']['price'] ?>">
			</legend>
			<legend>
				<label for="upload__product__image">Image</label>
				<small>Choose only if you want to change current image, 5MB max.Only png, jpg, and jpeg formats. </small>
				<input id="upload__product__image" accept="image/png, image/jpg, image/jpeg" class="upload__product__image " name="image" type="file" placeholder=" ">
			</legend>
			<legend class="product__btn__container">
				<button class="primary__btn product__save__btn">Save</button>
			</legend>
		</form>
	</div>
</main>

<script type='module'>
	const form = _dqs('.auth__form');

	(function() {
		for (let i = 0, option = form.category.options; i < form.category.options.length; i++) {
			if (option[i].value === "<?= $_SESSION['last_product']['category'] ?>") {
				option[i].setAttribute('selected', 'selected');
				break;
			}
		}
	}());

	_dqs('.product__btn__container').onclick = editProduct;
	async function editProduct() {
		const infoElement = _dqs('.error');

		//**validation */
		const {
			fieldOk,
			info,
			element
		} = _validateProductFields(form, form.image.value === "" ? true : false);

		if (!fieldOk) {
			_focus(element);
			return infoElement.textContent = info;
		}

		const formData = new FormData(form);
		if (form.image.value === "") {
			formData.delete('image');
		}
		formData.append('user_id', "<?= $_SESSION['user_id'] ?>")
		formData.append('product_id', "<?= $_GET['id'] ?>")
		try {
			const request = await fetch("./api/api_edit_product.php", {
				method: "POST",
				body: formData
			})

			const response = await request.json();
			infoElement.textContent = response?.info;
			if (request.ok) {
				infoElement.id = 'success';
				setTimeout(() => {
					window.location = './bridges/product_bridge.php';
				}, 2000);
			}
		} catch (error) {
			console.error(error?.message);
		}
	}
</script>

<?php
require_once(__DIR__ . '/components/bottom.php');
?>