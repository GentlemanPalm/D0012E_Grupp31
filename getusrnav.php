<?php
/*
 Till för att generera användar-html som kan visas. Antingen visas en logga-in knapp eller en länk till användarsidorna.
*/
require "connect.php"; 
session_start();
if (isset($_SESSION['user_ID'])) {
	$id = $_SESSION['user_ID'];
	$res = querySQL("SELECT first_name, last_name FROM Users WHERE ID = '$id'")->fetch_assoc();
?>
	<li><a href="userpane.php"><?=$res["first_name"]?> <?=$res["last_name"]?></a></li>
<?php
} else {
?>
	<li><a href="register.php">Registrera</a></li>
	<li><a href="login.php">Logga in</a></li>
<?php
}
?>