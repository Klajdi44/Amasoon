<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <nav>
    <a href="logout">Logout</a>
  </nav>
  <h1>
    <?php

    echo $_SESSION['user_name'];
    ?>
  </h1>
</body>

</html>