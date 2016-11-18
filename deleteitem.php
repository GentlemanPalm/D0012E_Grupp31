<?php
			session_start();
			$session_ID = session_ID();
			$val= $_GET['q'];
			$id = $item = "";
			$val = json_decode($val, true);
			$cart_ID = $val['ID'];
			$item = $val['item'];
			$user_ID = $val['user_ID'];
			
			$con = mysqli_connect('localhost','root','','paljon-4');
			if (!$con){
				die('Could not connect: ' . mysqli_error($con));
			}
			mysqli_select_db($con,"paljon-4");
			
			$sql="DELETE FROM cart WHERE item = '$item' AND user_ID = '$user_ID' AND ID = '$cart_ID' "; // Lägg till rätt ID här...
			$result = mysqli_query($con,$sql);
			mysqli_close($con);
			echo "gg";
?>