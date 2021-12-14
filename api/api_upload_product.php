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
if (!ctype_digit($_POST['price'])) _res(400, ['info' => 'Price must contain only numbers', 'error' => __LINE__]);

//image
if (!isset($_FILES['image'])) _res(400, ['info' => 'Image required', 'error' => __LINE__]);


$db = _db();
$imageId = uniqid('', true);
session_start();
try {
	$query = $db->prepare('INSERT INTO items(id,title,price,description,category,image,owner_id) VALUES(:id,:title,:price,:description, :category,:image, :owner_id)');
	$query->bindValue(':id', null);
	$query->bindValue(':title', $_POST['title']);
	$query->bindValue(':price', $_POST['price']);
	$query->bindValue(':description', $_POST['description']);
	$query->bindValue(':category', $_POST['category']);
	$query->bindValue(':image', $imageId);
	$query->bindValue(':owner_id', $_SESSION['user_id']);
	$query->execute();
	$row = $db->lastInsertId();

	if (!$row) {
		_res(400, ['info' => 'Failed to upload product', 'error' => __LINE__]);
	}

	move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../assets/$imageId");

	_res(200, ['info' => 'Uploaded product succesfully!']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
