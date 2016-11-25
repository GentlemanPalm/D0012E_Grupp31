<?php
require 'functions.php';
$error_str = "Kunde inte hitta någon product med ID: ";
if(isset($_GET["id"])) {
	$id = sanitizeString($_GET["id"]);
	querySQL("DELETE FROM Products WHERE ID = $id");
	global $connection;
	if($connection->affected_rows > 0) {
		echo "Produkten är borttagen!";
	} else {
		echo $error_str.$id;
	} 
} else {
	echo $error_str.$id;
}
