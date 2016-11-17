<?php
			session_start();
			$session_ID = session_ID();
			$user_ID = $_SESSION['user_ID'];
			$val= $_GET['q'];
			$id = $item = "";
			fixString($val);

			
			$con = mysqli_connect('localhost','root','','paljon-4');
			if (!$con){
				die('Could not connect: ' . mysqli_error($con));
			}
			mysqli_select_db($con,"paljon-4");
			$sql="DELETE FROM cart WHERE item = '$item' AND user_ID = '$user_ID' "; // Lägg till rätt ID här...
			$result = mysqli_query($con,$sql);
			mysqli_close($con);
			
			function fixString($val){
				global $id;
				global $item;
				$arr = explode(" ", $val);
				$item = $arr[0];
				$id = $arr[1];
			}
?>