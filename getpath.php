<?php

	require "connect.php";
		global $connection;
		$total= "0";
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID']) && !($_SESSION['user_ID']== 0)){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
		$name= $_GET['q'];

		
		$con = $connection;
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		
		$sql="SELECT id FROM Products WHERE name = '$name'";
		$result = mysqli_query($con,$sql);
	
		while($row = mysqli_fetch_array($result)) {
				$path = "viewproduct.php?id=".$row['id'];
				echo $path;
			}

?>