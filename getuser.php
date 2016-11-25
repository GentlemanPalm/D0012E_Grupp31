<?php
	require "connect.php";
	global $connection;
	
	$q = $_GET['q'];
	
	$con = $connection;
	
	if(!$con){
		die('Could not connect: ' . mysqli_error($con));
	}else{
		$sql = "SELECT * FROM Users WHERE id = '$q'";
		$result = mysqli_query($con, $sql);
		while($row = mysqli_fetch_array($result)) {
			$code = json_encode($row);
			echo $code;
		}
	}
	
	
	
?>
