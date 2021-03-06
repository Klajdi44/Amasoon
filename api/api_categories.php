<?php
require_once(__DIR__ . '/../private/globals.php');

$db = _db();

try {
	$query = $db->prepare('SELECT DISTINCT category FROM items');
	$query->execute();
	$row = $query->fetchAll();

	if (!$row) {
		_res(400, ['info' => 'No categories found', 'error' => __LINE__]);
	}

	_res(200, ['info' => $row]);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
