<?php	
		$id = $_GET['q'];

		
		$con = mysqli_connect('localhost','root','','paljon-4');
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"paljon-4");
		$sql="SELECT quantity FROM products WHERE ID = '$id'";
		$result = mysqli_query($con,$sql);

		while($row = mysqli_fetch_array($result)) {
			echo $row['quantity'];
		}
		mysqli_close($con);
?>