<?php
session_start();
unset($_SESSION["user_ID"]);
header("Location: index.php");
die();
?>