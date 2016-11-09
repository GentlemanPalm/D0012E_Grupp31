<?php
	require "connect.php";
	function sanitizeString($var){
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
  }
  

?>