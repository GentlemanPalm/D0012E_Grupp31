<?php
session_start();
		require "connect.php";
		global $connection;
		$total= "0";
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID']) && !($_SESSION['user_ID']== 0)){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
		$id= $_GET['q'];

		
		$con = $connection;
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}
		
		$sql="SELECT  Products.name, Products.price, Products.vat, Cart.item, Cart.ID, Cart.quantity FROM Products INNER JOIN Cart ON Cart.item = Products.ID AND Cart.user_ID = '$user_ID' WHERE Cart.order_ID IS NULL";
		$result = mysqli_query($con,$sql);
		echo "										<tr>
					<th>Produkt:</th>
					<th>Pris/st:</th>
					<th>Antal:</th>
					<th>Summa:</th>
				</tr>";
		while($row = mysqli_fetch_array($result)) {
						$row['user_ID'] = $user_ID;
						$totalprice = $row['quantity']*$row['price'] + $row['quantity']*$row['price']*$row['vat'];
						$total = sum($totalprice, $total);
						$unitprice = $row["price"] + $row["price"] * $row["vat"];
						$ggnice = array('user_ID'=>$row['user_ID'], 'ID'=>$row['ID'], 'item'=>$row['item']);
						$mew= json_encode ($ggnice);
						echo "
						<tr>
								<td>$row[name]</td>
								<td>$unitprice kr</td>
								<td>$row[quantity]st</td>
								<td>$totalprice:-</td>
								<td onClick=deleteItem('$mew'); style='cursor: pointer;'><img src = 'media/kryss.png' height='10px'></td>
							</tr>";
				
			}
		echo "<h4>Total:<br> $total kr</h4>";
		
		mysqli_close($con);
		
		function sum($price, $total){
			return $total+$price;
		}
?>
