<?php
require_once(__DIR__ . '/../private/globals.php');

//*validation *// 

//title
if (!isset($_POST['title'])) _res(400, ['info' => 'Title required', 'error' => __LINE__]);
if (strlen($_POST['title']) < _PRODUCT_TITLE_MIN_LEN) _res(400, ['info' => 'Title must be at least ' . _PRODUCT_TITLE_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['title']) > _PRODUCT_TITLE_MAX_LEN) _res(400, ['info' => 'Title cannot be more than' . _USERLASTNAME_MAX_LEN . ' characters long', 'error' => __LINE__]);

//description
if (!isset($_POST['description'])) _res(400, ['info' => 'Description required', 'error' => __LINE__]);
if (strlen($_POST['description']) < _PRODUCT_DESCRIPTION_MIN_LEN) _res(400, ['info' => 'Description must be at least ' . _PRODUCT_DESCRIPTION_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['description']) > _PRODUCT_DESCRIPTION_MAX_LEN) _res(400, ['info' => 'Description cannot be more than' . _PRODUCT_DESCRIPTION_MAX_LEN . ' characters long', 'error' => __LINE__]);

//category
if (!isset($_POST['category'])) _res(400, ['info' => 'Category required', 'error' => __LINE__]);
if (strlen($_POST['category']) < _PRODUCT_CATEGORY_MIN_LEN) _res(400, ['info' => 'Category must be at least ' . _PRODUCT_CATEGORY_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['category']) > _PRODUCT_CATEGORY_MAX_LEN) _res(400, ['info' => 'Category cannot be more than' . _PRODUCT_CATEGORY_MAX_LEN . ' characters long', 'error' => __LINE__]);

//price
if (!isset($_POST['price'])) _res(400, ['info' => 'Price required', 'error' => __LINE__]);
if ($_POST['price'] == 0) _res(400, ['info' => 'Price cannot be zero', 'error' => __LINE__]);
if (!ctype_digit($_POST['price'])) _res(400, ['info' => 'Price must contain only numbers', 'error' => __LINE__]);

$imageAvailable = isset($_FILES['image']);
if ($imageAvailable) {
	//image allowed types
	$image_allowed_types = [
		'png', 'jpg', 'jpeg'
	];

	$file_type = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	//check if file type is png,jpg or jpeg
	if (!in_array(strtolower($file_type), $image_allowed_types)) _res(400, ['info' => 'Only png, jpg, and jpeg formats
are allowed', 'error' => __LINE__]);
	//check if file is empty
	if (!filesize($_FILES['image']['tmp_name'])) _res(400, ['info' => 'Image cannot be empty', 'error' => __LINE__]);

	//check if file is not above 5mb
	// phpinfo() to see php.ini path to change config.
	if ($_FILES['image']['size'] > _IMAGE_MAX_SIZE) _res(400, ['info' => 'Image cannot exceed ' . _IMAGE_MAX_SIZE / 1000000 . 'MB', 'error' => __LINE__]);
}

$db = _db();
session_start();
$product = $_SESSION['last_product'];
$imageId = uniqid('', true);

try {
	$query = $db->prepare('UPDATE items SET title=:title,price = :price,description = :description,category = :category,image = :image WHERE id = :product_id');
	$query->bindValue(':title', $_POST['title']);
	$query->bindValue(':price', $_POST['price']);
	$query->bindValue(':description', $_POST['description']);
	$query->bindValue(':category', $_POST['category']);
	$query->bindValue(':product_id', $_POST['product_id']);
	if ($imageAvailable) {
		$query->bindValue(':image', $imageId);
	} else {
		$query->bindValue(':image', $product['image']);
	}
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(400, ['info' => 'Failed to update product', 'error' => __LINE__]);
	}

	if ($imageAvailable) {
		//upload new img
		move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../assets/$imageId");
		//delete previous image
		unlink(__DIR__ . "/../assets/" . $product['image']);
	}
	_res(200, ['info' => "success"]);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance or no fields changed, please make sure to edit a field before saving.', 'error' => __LINE__]);
}
