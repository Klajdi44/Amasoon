<?php
include_once(__DIR__ . '/../private/globals.php');

//validate key
if (!isset($_POST['key'])) {
	_res(400, ['info' => 'Suspicious...', 'error' => __LINE__]);
	exit();
}

if (strlen($_POST['key']) != 32) {
	_res(400, ['info' => 'Suspicious...', 'error' => __LINE__]);
	exit();
}

// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);
if ($_POST['user_password'] != $_POST['confirm_user_password']) _res(400, ['info' => 'Passwords do not match', 'error' => __LINE__]);

$db = _db();


try {
	//check if forgot  password key exists in db
	$query = $db->prepare('SELECT forgot_password_key from users where forgot_password_key = :forgot_password_key');
	$query->bindValue(':forgot_password_key', $_POST['key']);
	$query->execute();
	$row = $query->fetch();

	if (!$row) {
		_res(400, ['info' => 'Password key not found or expired', 'error' => __LINE__]);
	}
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}


try {
	$hashed_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
	$forgot_password_key = bin2hex(random_bytes(16));

	//update user password,forgo password key
	$query = $db->prepare('UPDATE users set user_password = :user_password, forgot_password_key = :new_forgot_password_key where forgot_password_key = :forgot_password_key');
	$query->bindValue(':user_password', $hashed_password);
	$query->bindValue(':forgot_password_key', $_POST['key']);
	$query->bindValue(':new_forgot_password_key', $forgot_password_key);
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(500, ['info' => 'Failed to create new password', 'error' => __LINE__]);
	}

	//success
	_res(200, ['info' => 'Password changed successfully']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
