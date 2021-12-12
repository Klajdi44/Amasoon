<?php
require_once(__DIR__ . '/../private/globals.php');

if (!isset($_POST['id']))
	_res(400, ['info' => 'Product id required']);

// if (!ctype_digit($_POST['user_id']))
// 	_res(400, ['info' => 'Id cannot contain letters']);


$db = _db();



try {
	$query = $db->prepare('SELECT * FROM items WHERE id = :id');
	$query->bindValue(':id', $_POST['id']);
	$query->execute();
	$row = $query->fetch();

	if (!$row) {
		_res(400, ['info' => 'No products found', 'error' => __LINE__]);
	}

	_res(200, ['info' => $row]);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
