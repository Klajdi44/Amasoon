<?php
require_once(__DIR__ . '/../private/globals.php');

$db = _db();

try {
	if (true) {
		$query = $db->prepare('SELECT category FROM items');
	} else {
		$query = $db->prepare('SELECT * FROM items WHERE category = :category');
	}
	$query->bindValue(':category', '*');
	$query->execute();
	$row = $query->fetchAll();

	if (!$row) {
		_res(400, ['info' => 'Email or Phone number does not exist', 'error' => __LINE__]);
	}

	_res(200, $row);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
