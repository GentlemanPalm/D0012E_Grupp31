<?php

session_start();
require 'functions.php';

if(!isset($_SESSION["user_ID"]) || !isset($_POST["submit"])) {
	die("Du har inte tillåtelse till detta!");
}

$id = sanitizeString($_POST["id"]);
$amount = abs(sanitizeString($_POST["amount"]));
$prices = querySQL("SELECT SUM(price * quantity) as totp, SUM(price * quantity * vat) as totv FROM OrderItems WHERE order_ID = '$id'")->fetch_assoc();
$price = $prices["totp"];
$vat = $prices["totv"]; 
$prev = querySQL("SELECT discount, payment_received FROM Orders WHERE ID = '$id'")->fetch_assoc();
$discount = $prev["discount"];
$recv = $prev["payment_received"] + $amount;
$tot = $price + $vat - $discount;

$tot = min($recv, $tot);
querySQL("UPDATE Orders SET payment_received = $tot WHERE ID = '$id'");

header("Location: vieworder.php?id=$id");
