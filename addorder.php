<?php
	require "functions.php";
	global $connection;
	include "template/header.php";
	generateHeader('Kassan');
	if ($_SESSION['user_ID'] == ""){
		header("Location:login.php");
	}	
	include "template/footer.php";

	function insert_address($type, $oid) {
		$email = sanitizeString($_POST[$type.'email']);
		$name = sanitizeString($_POST[$type.'name']);
		$lastname = sanitizeString($_POST[$type.'lastname']);
		$phone = sanitizeString($_POST[$type.'phone']);
		$town = sanitizeString($_POST[$type.'town']);
		$zip = sanitizeString($_POST[$type.'zip']);
		$address1 = sanitizeString($_POST[$type.'address1']);
		$t = strtoupper($type);
		querySQL("INSERT INTO OrderAddresses (ID, addr_type, email, first_name, last_name, phone, zip, address1, city, country)
			VALUES ($oid, '$t', '$email', '$name', '$lastname', '$phone', '$zip', '$address1', '$town', 'Sweden')");
		//die("INSERT INTO OrderAddresses (ID, addr_type, email, first_name, last_name, phone, zip, address1, city, country)
		//	VALUES ($oid, '$t', '$email', '$name', '$lastname', '$phone', '$zip', '$address1', '$town', 'Sweden')");
	}

	if (isset($_POST["submit"])){
		if ($user_ID == "" || querySQL("SELECT user_ID FROM Cart WHERE user_ID = '$user_ID'")->num_rows < 1){
			echo "Beställningen verkar vara tom!";
		}else{
			querySQL("START TRANSACTION");
			$query = querySQL("INSERT INTO Orders (user_ID, payment_option, payment_received, order_placed, discount)
					VALUES ('$user_ID', 'Faktura', 0.00, NOW(), 0)");
			$iid = mysqli_insert_id($connection);
			$query = querySQL("SELECT p.ID, c.quantity, p.price, p.vat FROM Cart c INNER JOIN Products p ON c.item=p.ID WHERE c.user_ID = $user_ID");
			while ($res = $query->fetch_assoc()) {
				querySQL("INSERT INTO OrderItems (order_ID, item, quantity, price, vat, shipped) VALUES ('$iid', '$res[ID]', '$res[quantity]', '$res[price]', '$res[vat]', NULL)");
			}
			querySQL("DELETE FROM Cart WHERE user_ID = '$user_ID'");
			querySQL("COMMIT");
			//querySQL("UPDATE Cart SET order_ID = $iid WHERE (user_ID = $user_ID AND order_ID IS NULL)"); 
		
			if (isset($_POST["billing"])) {
				insert_address("b", $iid);
			}
			if (isset($_POST["shipping"])) {
				insert_address("s", $iid);
			}
		}
		
	}
?>
	<meta charset= "UTF-8"/>
	<script src = "getuser.js" charset="UTF-8"></script>
	<script src ="cart.js"></script>
	<script>
		window.onload = function(){
			loadCart('<?php echo $user_ID;?>');
			loaduser('<?php echo $user_ID;?>')
	}
	</script>
	<div class = "container">
		<h1>Din Varukorg:</h1>
		<div class = "table table-responsive">
			<table id = "cart"class ="table table-striped">
				
			</table>
			<hr>
		</div>

			<h2>Uppgifter:</h2>
			<br>
			<form action ="" method = "POST">
			
				<input type="checkbox" class="form-control" id="billing" name="billing">Jag vill ha en annan fakturaadress än min användaradress</input><br />
				<input type = "text" disabled="disabled" class = "form-control bill" name = "bname" id = "name" placeholder = "Förnamn" ><br />
				<input type = "text" disabled="disabled" class = "form-control bill" name = "blastname" id = "lastname" placeholder = "Efternamn" ><br>
				<input type="email" disabled="disabled" class = "form-control bill" id ="email" name = "bemail" placeholder="E-post"><br>
				<input type="text" disabled="disabled" class = "form-control bill" name = "baddress1" id = "address1" placeholder="Address"><br>
				<input type = "text" disabled="disabled" class = "form-control bill" name = "bzip" id = "zip" placeholder = "Postnummer"><br>
				<input type = "text" disabled="disabled" class = "form-control bill" name = "btown" placeholder = "Ort" id ="city"><br>
				<input type = "text" disabled="disabled" class = "form-control bill" name = "bphone" id ="phone" placeholder = "Telefonnummer"><br>

				<input type="checkbox" class="form-control" id="shipping" name="shipping">Jag vill ha en annan leveransadress än min användaradress</input><br />
				<input type = "text" disabled="disabled" class = "form-control ship" name = "sname" id = "name" placeholder = "Förnamn" ><br />
				<input type = "text" disabled="disabled" class = "form-control ship" name = "slastname" id = "lastname" placeholder = "Efternamn" ><br>
				<input type="email" disabled="disabled" class = "form-control ship" id ="email" name = "semail" placeholder="E-post"><br>
				<input type="text" disabled="disabled" class = "form-control ship" name = "saddress1" id = "address1" placeholder="Address"><br>
				<input type = "text" disabled="disabled" class = "form-control ship" name = "szip" id = "zip" placeholder = "Postnummer"><br>
				<input type = "text" disabled="disabled" class = "form-control ship" name = "stown" placeholder = "Ort" id ="city"><br>
				<input type = "text" disabled="disabled" class = "form-control ship" name = "sphone" id ="phone" placeholder = "Telefonnummer"><br>


				<input type = "submit" name = "submit" value="Lägg order" class="btn btn-success btn-block"><br><br>
			</form>
			<script type="text/javascript">
				$("#billing").click(function () {
					var isChecked = this.checked;
					$(".bill").each(function () {
						$(this).prop("disabled", !isChecked);
					}); // http://stackoverflow.com/questions/24689636/enable-inputs-from-bootstrap-checkbox
				});

				$("#shipping").click(function () {
					var isChecked = this.checked;
					$(".ship").each(function () {
						$(this).prop("disabled", !isChecked);
					}); // http://stackoverflow.com/questions/24689636/enable-inputs-from-bootstrap-checkbox
				});
			</script>
		</div>
			
	</div>

<?php
	generateFooter($generate_cart=false);
?>
