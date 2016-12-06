<?php
require_once "functions.php";
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-12-06
 * Time: 10:41
 */

if (!isset($_GET['email'])) {
    echo "-1";
}

$email = sanitizeString($_GET['email']);
$result = querySQL("SELECT * FROM Users WHERE email = '$email'");
if ($result->num_rows > 0) {
    echo "0";
} else {
    echo "1";
}