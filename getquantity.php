<?php	
		require "connect.php";
		global $connection;
		$id = $_GET['q'];

		
		$con = $connection;
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		
		$sql="SELECT quantity FROM Products WHERE ID = '$id'";
		$result = mysqli_query($con,$sql);

		while($row = mysqli_fetch_array($result)) {
			echo "Lagersaldo: $row[quantity]";
		}
		mysqli_close($con);
?>
