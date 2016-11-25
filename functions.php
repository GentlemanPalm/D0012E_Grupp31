<?php
	require "connect.php";
	function sanitizeString($var){
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
  }
	function fixDate($year, $month, $day){
		$result = $year."-".$month."-".$day;
		return $result;
	}
	
	function fixSecurityNumber($year, $month, $day, $ssn){
		$year = $year % 100;
		$result = $year.$month.$day."-".$ssn;
		return $result;
	}
	function getRegistrationDate(){
	    $year = date('Y', time());
		$month = date('m', time());
		$day = date('d', time());
		$result = $year."-".$month."-".$day;
		return $result;
	}
  

?>