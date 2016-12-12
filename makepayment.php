<?php

session_start();
require 'functions.php';

if(!isset($_SESSION["user_ID"]) || !isset($_POST["submit"])) {
	die("Du har inte tillåtelse till detta!");
}

$id = sanitizeString($_POST["id"]);
$amount = abs(sanitizeString($_POST["amount"]));

querySQL("UPDATE Orders SET payment_received = payment_received + $amount WHERE ID = '$id'");

header("Location: vieworder.php?id=$id");
