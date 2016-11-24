<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>

		<?php
		session_start();
		require "connect.php";
		global $connection;
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID']) && !($_SESSION['user_ID']== 0) ){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
		$q = $_GET['q'];
		$id = $quantity = "";
		fixString($q);
		
		$con = $connection;
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		$sql="SELECT * FROM products WHERE ID = '$id'";
		$result = mysqli_query($con,$sql);

		while($row = mysqli_fetch_array($result)) {
			if(check_quantity($id, $quantity, $con)){
				$newQuantity = $row['quantity'] - $quantity;
				$sql = "UPDATE products SET quantity = '$newQuantity' WHERE id = '$q'";
				mysqli_query($con, $sql);
					$sql="INSERT INTO cart(user_ID, item, quantity) VALUES ('$user_ID', '$id', '$quantity')";
				mysqli_query($con, $sql);
				echo "Produkt tillagd i varukorgen";
			}else{
				echo "Vi har tyvärr inte tillräckligt många i lager.";
			}
		}
		mysqli_close($con);
		
		
		function fixString($val){
			global $id;
			global $quantity;
			$arr = explode(" ", $val);
			$id = $arr[0];
			$quantity = $arr[1];
		}
		
		function check_quantity($id, $quantity, $con){
			$sql="SELECT quantity FROM products WHERE ID = '$id'";
			$result = mysqli_query($con,$sql);

			while($row = mysqli_fetch_array($result)) {
			if($row['quantity']< $quantity){
				return False;
			}else{
				return True;
				}
			}
		}
		?>
	</body>
</html>