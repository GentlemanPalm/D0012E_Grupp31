<?php
session_start();
require 'functions.php';

if(!isset($_SESSION["user_ID"]) || $_SESSION["access"] < 2) {
	die("Du har inte tillåtelse till detta!");
}

$id = sanitizeString($_GET["id"]);
querySQL("UPDATE OrderItems SET shipped = NOW() WHERE ID = '$id'");