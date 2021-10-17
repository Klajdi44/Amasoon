<?php
require_once(__DIR__ . '/../globals.php');

// Validate
if (!isset($_POST['user_email'])) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);


// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'Password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);

try {
  $db = _db();
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}

// check if email exists
try {
  $query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
  $query->bindValue(':user_email', $_POST['user_email']);
  $query->execute();
  $row = $query->fetch();

  if (!$row) {
    _res(400, ['info' => 'Email does not exist', 'error' => __LINE__]);
  }

  //verify password
  if (!password_verify($_POST['user_password'], $row['user_password'])) {
    _res(400, ['info' => "Wrong password"]);
  }

  // Success
  session_start();
  $_SESSION['user_id'] = $row['user_id'];
  $_SESSION['user_name'] = $row['user_name'];
  _res(200, ['info' => 'success login']);
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
