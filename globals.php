<?php
define('_USERNAME_MIN_LEN', 1);
define('_USERNAME_MAX_LEN', 50);
define('_PASSWORD_MIN_LEN', 8);
define('_PASSWORD_MAX_LEN', 20);


function _res($status = 200, $message = [], $exit = true)
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($message);
  if ($exit) exit();
}


function _db()
{
  $database_user_name = 'root';
  $database_password = 'root';
  $database_connection = 'mysql:host=localhost; dbname=amasoon; charset=utf8mb4';

  $database_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  return new PDO($database_connection, $database_user_name, $database_password, $database_options);
}
