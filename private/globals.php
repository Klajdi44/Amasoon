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

function _is_user_signed_in()
{
  session_start();
  return $_SESSION['user_id'];
}


function _db()
{
  try {
    $database_user_name = 'root';
    $database_password = 'root';
    $database_connection = 'mysql:host=localhost; dbname=amasoon; charset=utf8mb4';

    $database_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    return new PDO($database_connection, $database_user_name, $database_password, $database_options);
  } catch (Exception $ex) {
    _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
  }
}
