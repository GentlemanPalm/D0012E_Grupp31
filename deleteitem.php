<?php
			session_start();
			require "connect.php";
			global $connection;
			$session_ID = session_ID();
			$val= $_GET['q'];
			$id = $item = "";
			$val = json_decode($val, true);
			echo $cart_ID = $val['ID'];
			echo $item = $val['item'];
			echo $user_ID = $val['user_ID'];
			
			$con = $connection;
			if (!$con){
				die('Could not connect: ' . mysqli_error($con));
			}
			
			$sql="DELETE FROM cart WHERE item = '$item' AND user_ID = '$user_ID' AND ID = '$cart_ID' "; // Lägg till rätt ID här...
			$result = mysqli_query($con,$sql);
			mysqli_close($con);
?>