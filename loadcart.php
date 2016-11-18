<?php
session_start();
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID']) && !($_SESSION['user_ID']== 0)){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
		$id= $_GET['q'];

		
		$con = mysqli_connect('localhost','root','','paljon-4');
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"paljon-4");
		
		$sql="SELECT  products.name, products.price, cart.item, cart.ID, cart.quantity FROM products INNER JOIN cart ON cart.item = products.ID AND (cart.user_ID = '$id' OR cart.session_ID = '$session_ID')";
		$result = mysqli_query($con,$sql);
		echo "										<tr>
					<th>Produkt:</th>
					<th>Pris:</th>
					<th>Antal:</th>
				</tr>";
		while($row = mysqli_fetch_array($result)) {
						$row['user_ID'] = $user_ID;
						$mew= json_encode ($row);
						echo "
						<tr>
								<td>$row[name]</td>
								<td>$row[price]:-</td>
								<td>$row[quantity]st</td>
								<td onClick=deleteItem('$mew'); style='cursor: pointer;'><img src = 'media/kryss.png' height='10px'></td>
							</tr><br>";
				
			}
		
		mysqli_close($con);
?>