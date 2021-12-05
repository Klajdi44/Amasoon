<?php
require_once(__DIR__ . '/../private/globals.php');

// Validate
if (!isset($_POST['user_name'])) _res(400, ['info' => 'Name required', 'error' => __LINE__]);
if (strlen($_POST['user_name']) < _USERNAME_MIN_LEN) _res(400, ['info' => 'Name must be at least ' . _USERNAME_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_name']) > _USERNAME_MAX_LEN) _res(400, ['info' => 'Name cannot be more than' . _USERNAME_MAX_LEN . ' characters long', 'error' => __LINE__]);
if (_contains_number($_POST['user_name'])) _res(400, ['info' => 'Name cannot contain numbers', 'error' => __LINE__]);

//validate email
if (!isset($_POST['user_email'])) _res(400, ['info' => 'email required', 'error' => __LINE__]);
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) _res(400, ['info' => 'Email is invalid', 'error' => __LINE__]);


// Validate the password
if (!isset($_POST['user_password'])) _res(400, ['info' => 'password required']);
if (strlen($_POST['user_password']) < _PASSWORD_MIN_LEN) _res(400, ['info' => 'Password must be at least ' . _PASSWORD_MIN_LEN . ' characters long', 'error' => __LINE__]);
if (strlen($_POST['user_password']) > _PASSWORD_MAX_LEN) _res(400, ['info' => 'Password cannot be more than' . _PASSWORD_MAX_LEN . ' characters long', 'error' => __LINE__]);
if ($_POST['user_password'] != $_POST['confirm_password']) _res(400, ['info' => 'Passwords do not match', 'error' => __LINE__]);

//validate phone number
if (!isset($_POST['user_phone_number'])) _res(400, ['info' => 'Phone number required']);
if (strlen($_POST['user_phone_number']) < _PHONE_LEN || strlen($_POST['user_phone_number']) > _PHONE_LEN) _res(400, ['info' => 'Phone number must be ' . _PHONE_LEN . ' characters long', 'error' => __LINE__]);
if (!ctype_digit($_POST['user_phone_number'])) _res(400, ['info' => 'Phone number must contain only numbers', 'error' => __LINE__]);

$db = _db();
try {
  $query = $db->prepare('SELECT * FROM users WHERE user_email = :user_email OR user_phone_number = :user_phone_number');
  $query->bindValue('user_email', $_POST['user_email']);
  $query->bindValue('user_phone_number', $_POST['user_phone_number']);
  $query->execute();
  $row = $query->fetch();


  if ($row['user_email'] === $_POST['user_email']) {
    _res(400, ['info' => 'Email already exists', 'error' => __LINE__]);
  }

  if ($row['user_phone_number'] === $_POST['user_phone_number']) {
    _res(400, ['info' => 'Phone number already exists', 'error' => __LINE__]);
  }

  $password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
  $verification_key = bin2hex(random_bytes(16));
  $forgot_password_key = bin2hex(random_bytes(16));

  $query = $db->prepare('INSERT INTO users(user_id,user_name,user_email,user_phone_number,user_password,user_verification_key,forgot_password_key) VALUES(:user_id,:user_name,:user_email,:user_phone_number, :user_password,:user_verification_key,:forgot_password_key)');
  $query->bindValue(':user_id', null);
  $query->bindValue(':user_name', $_POST['user_name']);
  $query->bindValue(':user_email', $_POST['user_email']);
  $query->bindValue(':user_phone_number', $_POST['user_phone_number']);
  $query->bindValue(':user_password', $password_hash);
  $query->bindValue(':user_verification_key', $verification_key);
  $query->bindValue(':forgot_password_key', $forgot_password_key);
  $query->execute();


  $user_id = $db->lastinsertid();
  if (!$user_id) _res(400, ['info' => 'Failed to create user', 'error' => __LINE__]);

  $_to_email = $_POST['user_email'];
  $_name = $_POST['user_name'];
  $_subject = "Email verification";
  $_message = "Thank you for signing up $_name!,
   <a href='http://localhost:8080/amasoon/verify-email.php?key=$verification_key'> click here to verify your account </a>";
  require_once(__DIR__ . '/../private/send_email.php');

  // Success
  session_start();
  $_SESSION = ['user_name' => $_POST['user_name'], 'user_id' => $user_id, 'user_email' => $_POST['user_email'], 'user_phone_number' => $_POST['user_phone_number'], 'is_verified' => false];

  _res(200, ['info' => 'Signed up successfully', "user_id" => $user_id], false);
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}


try {
  //send sms
  $url = 'https://fatsms.com/send-sms';
  $data = [
    'email' => $_POST['email'],
    'to_phone' => $_POST['user_phone_number'],
    'api_key' => $_sms_api_key,
    'message' =>  "Thank you for signing up on Amasoon! Please verify your account on your email!"
  ];
  $sms_response = _curl_post($url, $data);

  if ($sms_response != 'OK') {
    //TODO: maybe add another field to db e.g sms_sent if false then try to connect to db and change that to 1
  }
  exit();
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
