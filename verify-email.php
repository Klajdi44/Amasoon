<?php
if (!isset($_GET['key'])) {
	// (the key is missing so the user is trying to do something suspicious)
	echo "Suspicious...";
	exit();
}

if (strlen($_GET['key']) != 32) {
	//the key is not 32 characters long meaning user is doing something dodgy
	echo "Suspicious...";
	exit();
}

require_once(__DIR__ . '/private/globals.php');

$db = _db();

try {
	$query = $db->prepare('SELECT * FROM users where user_verification_key = :user_verification_key');
	$query->bindValue(":user_verification_key", $_GET['key']);
	$query->execute();
	$row = $query->fetch();

	if (!$row) {
		_res(400, ['info' => 'Verification key missmatch, try again later or contact support', 'error' => __LINE__]);
	}

	if ($row['is_verified']) {
		header('Location: index');
		exit();
	}


	$query = $db->prepare('UPDATE users SET is_verified = 1 WHERE user_verification_key = :user_verification_key ');
	$query->bindValue(":user_verification_key", $_GET['key']);
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(500, ['info' => 'Could not verify email, please try again later', 'error' => __LINE__]);
	}

	// header('Location: index');
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
