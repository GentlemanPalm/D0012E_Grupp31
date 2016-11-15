<?php
	require_once 'functions.php';
	$email = $orgnr = $password = $name = $lastname = $securityNumber = $phonenumber = $town = $zipcode = $address1 = $address2 = $addressco = "";
	//Undviker SQL-injection
	if (isset($_POST["submit"])){
		global $connection;
		$pname = sanitizeString($_POST["pname"]);
		$quantity = sanitizeString($_POST["quantity"]);
		$desc = $connection->real_escape_string($_POST["desc"]);
		$price = sanitizeString($_POST["price"]);
		$vat = sanitizeString($_POST["vat"]);
		echo $vat;
	//	$address2 = sanitizeString($_POST['address2']);
	//	$addressco = sanitizeString($_POST['addressco']);
		//Kontrollerar om alla fällt är ifyllda.
		if ($pname == "" || $quantity < 0 || $desc =="" || $price < 0){
				echo "Not all fields were entered correctly.";
		}else{
			$query = querySQL("INSERT INTO Products(name, quantity, description, price, vat, added, current_price) VALUES ('$pname', $quantity, '$desc', $price, $vat, NOW(), $price);");
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<script>
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
			}
	</script>
	</head>
	<body>
	<h1>Registrering</h1>
		<form action = "" method = "POST">
			Produktnamn:
			<input type = "text" name = "pname"/><br><br>
			
			Ursprungligt lagersaldo:
			<input type = "text" name = "quantity" onkeypress="return isNumber(event)" maxlength = "4" size = "4" /><br><br>

			Produktbeskrivning (tillåter HTML):
			<textarea name="desc" cols="40" rows="10"></textarea><br /><br />
			
			Pris exklusive moms:
			<input type = "text" name = "price" onkeypress="return isNumber(event)" maxlength = "6" size = "6" /><br><br>
			
			Momssats:
			<select name="vat">
				<option value = "0.06">6% - Kultur, böcker, mm.</option>
				<option value = "0.12">12% - Livsmedel, mm.</option>
				<option value = "0.25">25% - ALLA digitala tjänster och övriga artiklar</option>
			</select><br><br>

			<input type = "submit" name = "submit" value = "Lägg till vara!"/>
			<hr>			
		</form>
	</body>
</html>