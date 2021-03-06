<?php
require_once(__DIR__ . '/../private/globals.php');

//validate email
if (!isset($_POST['user_email'])) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);

$db = _db();

try {
	//check if email exists
	$query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
	$query->bindValue('user_email', $_POST['user_email']);
	$query->execute();
	$row = $query->fetch();

	if (!$row) {
		_res(400, ['info' => 'Email does not exists', 'error' => __LINE__]);
	}

	//password key from db
	$forgot_password_key = $row['forgot_password_key'];

	// send email
	$_to_email = $_POST['user_email'];
	$_name = $row['user_name'];
	$_subject = "Password assistance";
	$_message = "Hello $_name, you forgot your password,
   <a href='http://localhost:8080/new-password.php?key=$forgot_password_key'> click here to create a new one!</a>";
	require_once(__DIR__ . '/../private/send_email.php');

	//success
	_res(200, ['info' => 'Email sent successfully']);
} catch (Exception $ex) {
	_res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
