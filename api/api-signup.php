<?php
require_once(__DIR__ . '/../private/globals.php');

// Validate
if (!isset($_POST['user_name'])) _res(400, ['info' => 'Name required', 'error' => __LINE__]);
if (strlen($_POST['user_name']) < _USERNAME_MIN_LEN) _res(400, ['info' => 'Name must be at least ' . _USERNAME_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_name']) > _USERNAME_MAX_LEN) _res(400, ['info' => 'Name cannot be more than' . _USERNAME_MAX_LEN . ' characters long', 'error' => __LINE__]);

//validate email
if (!isset($_POST['user_email']) || (strlen($_POST['user_email']) <= 0)) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);


// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);
if ($_POST['user_password'] != $_POST['re-enter_user_password']) _res(400, ['info' => 'Passwords do not match', 'error' => __LINE__]);

$db = _db();
try {
  $query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
  $query->bindValue('user_email', $_POST['user_email']);
  $query->execute();
  $row = $query->fetch();

  if ($row) {
    _res(400, ['info' => 'Email already exists', 'error' => __LINE__]);
  }

  $password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
  $verification_key = bin2hex(random_bytes(16));

  $query = $db->prepare('INSERT INTO users(user_id,user_name,user_email,user_password,user_verification_key) VALUES(:user_id,:user_name,:user_email, :user_password,:user_verification_key)');
  $query->bindValue(':user_id', null);
  $query->bindValue(':user_name', $_POST['user_name']);
  $query->bindValue(':user_email', $_POST['user_email']);
  $query->bindValue(':user_password', $password_hash);
  $query->bindValue(':user_verification_key', $verification_key);
  $query->execute();

  //TODO:change the info message below
  $user_id = $db->lastinsertid();
  if (!$user_id) _res(400, ['info' => 'Wrong credentials', 'error' => __LINE__]);

  // Success
  session_start();
  $_SESSION['user_name'] = $_POST['user_name'];
  $_SESSION['user_id'] = $user_id;
  _res(200, ['info' => 'success signup', "user_id" => $user_id]);
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
