<?php
if (!isset($_POST['key']) || strlen($_POST['key']) != 32) {
	// (the key is missing so the user is trying to do something suspicious)
	_res(400, ['info' => 'Suspicious', 'error' => __LINE__]);
	exit();
}
require_once(__DIR__ . '/../private/globals.php');

$db = _db();

//see if key exists
try {
	$query = $db->prepare('CALL get_email_verification_key(:user_verification_key)');
	$query->bindValue(":user_verification_key", $_POST['key']);
	$query->execute();
	$row = $query->fetch();

	if (!$row) {
		_res(400, ['info' => 'Verification key not found or invalid', 'error' => __LINE__]);
	}
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}

try {
	$query = $db->prepare('UPDATE users SET is_verified = 1 WHERE user_verification_key = :user_verification_key ');
	$query->bindValue(":user_verification_key", $_POST['key']);
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(500, ['info' => 'Could not verify email', 'error' => __LINE__]);
	}

	session_start();
	$_SESSION['is_verified'] = true;
	_res(200, ['info' => 'Email verified successfully']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
