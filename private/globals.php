<?php
define('_USERNAME_MIN_LEN', 1);
define('_USERNAME_MAX_LEN', 50);
define('_USERLASTNAME_MIN_LEN', 1);
define('_USERLASTNAME_MAX_LEN', 50);
define('_PASSWORD_MIN_LEN', 8);
define('_PASSWORD_MAX_LEN', 20);
define('_PHONE_LEN', 8);
define('_PRODUCT_TITLE_MIN_LEN', 1);
define('_PRODUCT_TITLE_MAX_LEN', 150);
define('_PRODUCT_DESCRIPTION_MIN_LEN', 10);
define('_PRODUCT_DESCRIPTION_MAX_LEN', 500);
define('_PRODUCT_CATEGORY_MIN_LEN', 1);
define('_PRODUCT_CATEGORY_MAX_LEN', 50);
//5mb
define('_IMAGE_MAX_SIZE', 5000000);




function _res($status = 200, $message = [], $exit = true)
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($message);
  if ($exit) exit();
}

$_sms_api_key = '87ebf26b-37b1-4a5d-8eba-7bfd4709d2f3';

function _curl_post($url, $data)
{
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  curl_close($curl);
  return  $response;
}

function _is_user_signed_in()
{
  session_start();
  if (!isset($_SESSION['user_id'])) {
    return false;
  } else {
    return true;
  }
  exit();
}
function _handle_loggedin_status($path = 'index')
{
  if (!_is_user_signed_in()) {
    header("Location: $path");
  }
}

function  _contains_number($string)
{
  for ($i = 0; $i < strlen($string); $i++) {
    if (ctype_digit($string[$i])) {
      return true;
    }
  }
  return false;
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
