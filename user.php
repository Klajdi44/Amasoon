<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}

include_once('./components/top.php');
?>

<nav>
  <a href="./bridges/logout.php">Logout</a>
</nav>
<h1>
  <?php

  echo $_SESSION['user_name'];
  ?>
</h1>

<?php
include_once('./components/bottom.php');
?>