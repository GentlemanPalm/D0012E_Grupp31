<?php
session_start();
require 'functions.php';

if ($_SESSION["access"] < 2) {
	header("Location: viewproduct.php?id=$_GET[pid]");
	die();
}
$id = sanitizeString($_GET["id"]);
querySQL("UPDATE Comments SET approved = true WHERE ID = $id");

header("Location: viewproduct.php?id=$_GET[pid]");
?>
