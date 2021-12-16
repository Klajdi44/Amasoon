<?php
session_start();
header("Location: ../product-overview.php?id={$_SESSION['last_product']['id']}");
