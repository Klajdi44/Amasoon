<?php
require_once(__DIR__ . '/../private/globals.php');

// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);
if ($_POST['user_password'] != $_POST['confirm_user_password']) _res(400, ['info' => 'Passwords do not match', 'error' => __LINE__]);

$db = _db();

try {
	$hashed_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
	session_start();
	//update user password
	$query = $db->prepare('UPDATE users set user_password = :user_password WHERE user_id = :user_id');
	$query->bindValue(':user_id', $_SESSION['user_id']);
	$query->bindValue(':user_password', $hashed_password);
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(500, ['info' => 'Failed to change password', 'error' => __LINE__]);
	}

	//success
	_res(200, ['info' => 'Password changed successfully']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
