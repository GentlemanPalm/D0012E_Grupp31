<?php
require_once "connect.php";
global $connection;
$search = $_GET['q'];


$con = $connection;
		if ($search == ""){}
		else{
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}else{
			$sql = "SELECT * FROM Products WHERE name LIKE '%$search%'";
			$result = mysqli_query($con,$sql);
			while($row = mysqli_fetch_array($result)) {
				echo"<option onchange=gohere($row[ID])>$row[name]</option>";
			}
			}
		}





?>