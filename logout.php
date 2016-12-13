<?php
session_start();
unset($_SESSION["user_ID"]);
unset($_SESSION["access"]);
session_destroy();
header("Location: index.php");
die();
?>