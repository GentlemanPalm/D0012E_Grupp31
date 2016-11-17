<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>

		<?php
		session_start();
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID']) && !($_SESSION['user_ID']== 0) ){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
		$q = $_GET['q'];
		$id = $quantity = "";
		fixString($q);
		
		$con = mysqli_connect('localhost','root','','paljon-4');
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"paljon-4");
		$sql="SELECT * FROM products WHERE ID = '$id'";
		$result = mysqli_query($con,$sql);

		while($row = mysqli_fetch_array($result)) {
			if(check_quantity($id, $quantity, $con)){
				$newQuantity = $row['quantity'] - $quantity;
				$sql = "UPDATE products SET quantity = '$newQuantity' WHERE id = '$q'";
				mysqli_query($con, $sql);
				if($user_ID==0){
					$sql="INSERT INTO cart(session_ID, user_ID, item, quantity, shipped) VALUES ('$session_ID','', '$id', '$quantity', '0')";
				}else{
					$sql="INSERT INTO cart(session_ID, user_ID, item, quantity, shipped) VALUES ('$session_ID','$user_ID', '$id', '$quantity', '0')";
				}
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