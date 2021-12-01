<?php
require_once(__DIR__ . '/../private/globals.php');

// **validation**
//Name
if (!isset($_POST['user_name'])) _res(400, ['info' => 'Name required', 'error' => __LINE__]);
if (strlen($_POST['user_name']) < _USERNAME_MIN_LEN) _res(400, ['info' => 'Name must be at least ' . _USERNAME_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_name']) > _USERNAME_MAX_LEN) _res(400, ['info' => 'Name cannot be more than' . _USERNAME_MAX_LEN . ' characters long', 'error' => __LINE__]);

// email
if (!isset($_POST['user_email'])) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);

// phone number
if (!isset($_POST['user_phone_number'])) _res(400, ['info' => 'Phone number required']);
if (strlen($_POST['user_phone_number']) < _PHONE_LEN || strlen($_POST['user_phone_number']) > _PHONE_LEN) _res(400, ['info' => 'Phone number must be ' . _PHONE_LEN . ' characters long', 'error' => __LINE__]);
if (!ctype_digit($_POST['user_phone_number'])) _res(400, ['info' => 'Phone number must contain only numbers', 'error' => __LINE__]);

$db = _db();

try {
	session_start();
	$has_email_changed =  $_POST['user_email'] != $_SESSION['user_email'] ? true : false;

	$query = $db->prepare('UPDATE users SET user_name = :user_name,user_email = :user_email, user_phone_number = :user_phone_number WHERE user_id = :user_id');
	$query->bindValue(':user_id', $_SESSION['user_id']);
	$query->bindValue(':user_name', $_POST['user_name']);
	$query->bindValue(':user_email', $_POST['user_email']);
	$query->bindValue(':user_phone_number', $_POST['user_phone_number']);
	$query->execute();
	$row = $query->rowCount();

	if (!$row) {
		_res(500, ['info' => 'Failed to update fields', 'error' => __LINE__]);
	}

	$_SESSION['user_name'] = $_POST['user_name'];
	$_SESSION['user_email'] = $_POST['user_email'];
	$_SESSION['user_phone_number'] = $_POST['user_phone_number'];
	_res(200, ['info' => 'Success']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
