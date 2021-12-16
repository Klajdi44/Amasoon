<?php
require_once(__DIR__ . '/../private/globals.php');

$db = _db();

try {
	if (!isset($_POST['category'])) {
		$query = $db->prepare('SELECT * FROM items');
	} else {
		$query = $db->prepare('SELECT * FROM items WHERE category = :category');
	}
	$query->bindValue(':category', $_POST['category']);
	$query->execute();
	$row = $query->fetchAll();

	if (!$row) {
		_res(400, ['info' => 'Failed to retrieve products', 'error' => __LINE__]);
	}

	_res(200, $row);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
