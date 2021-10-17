<?php

require_once(__DIR__ . '/../globals.php');

// Validate

if (!isset($_POST['user_name'])) _res(400, ['info' => 'Name required', 'error' => __LINE__]);
if (strlen($_POST['user_name']) < _USERNAME_MIN_LEN) _res(400, ['info' => 'Name must be at least ' . _USERNAME_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_name']) > _USERNAME_MAX_LEN) _res(400, ['info' => 'Name cannot be more than' . _USERNAME_MAX_LEN . ' characters long', 'error' => __LINE__]);

//validate email
if (!isset($_POST['user_email'])) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);


// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);
if ($_POST['user_password'] != $_POST['re-enter_user_password']) _res(400, ['info' => 'Passwords do not match', 'error' => __LINE__]);

try {
  $db = _db();
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}

try {
  $password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

  $query = $db->prepare('INSERT INTO users VALUES(:user_id,:user_name,:user_email, :user_password)');
  $query->bindValue(':user_id', null);
  $query->bindValue(':user_name', $_POST['user_name']);
  $query->bindValue(':user_email', $_POST['user_email']);
  $query->bindValue(':user_password', $password_hash);
  $query->execute();

  $user_id = $db->lastinsertid();
  if (!$user_id) _res(400, ['info' => 'wrong credentials', 'error' => __LINE__]);

  // Success
  session_start();
  $_SESSION['user_name'] = $_POST['user_name'];
  $_SESSION['user_id'] = $user_id;
  _res(200, ['info' => 'success signup', "user_id" => $user_id]);
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
