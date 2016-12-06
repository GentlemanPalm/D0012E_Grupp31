<?php
			session_start();
			require "connect.php";
			global $connection;
			$session_ID = session_ID();
			$val= $_GET['q'];
			$id = $item = "";
			$val = json_decode($val, true);
			echo $item = $val['item'];
			echo $user_ID = $val['user_ID'];
			
			$con = $connection;
			if (!$con){
				die('Could not connect: ' . mysqli_error($con));
			}
			
			$sql="DELETE FROM Cart WHERE item = '$item' AND user_ID = '$user_ID'"; // Lägg till rätt ID här...
			$result = mysqli_query($con,$sql);
			mysqli_close($con);
?>
