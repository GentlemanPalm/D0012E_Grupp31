<?php
	require_once 'functions.php';
	$email = $orgnr = $password = $name = $lastname = $securityNumber = $phonenumber = $town = $zipcode = $address1 = $address2 = $addressco = "";
	//Undviker SQL-injection
	if (isset($_POST["submit"])){
		$email = sanitizeString($_POST['email']);
		$password = sanitizeString($_POST['password']);
		$name = sanitizeString($_POST['name']);
		$lastname = sanitizeString($_POST['lastname']);
		$securityNumber = sanitizeString($_POST['securityNumber']);
		$phonenumber = sanitizeString($_POST['phonenumber']);
		$town = sanitizeString($_POST['town']);
		$zipcode = sanitizeString($_POST['zipcode']);
		$address1 = sanitizeString($_POST['address1']);
		$address2 = sanitizeString($_POST['address2']);
		$addressco = sanitizeString($_POST['addressco']);
		$orgnr = sanitizeString($_POST['orgnr']);
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
	//	$address2 = sanitizeString($_POST['address2']);
	//	$addressco = sanitizeString($_POST['addressco']);
		//Kontrollerar om alla fällt är ifyllda.
		if ($email == "" || $password == "" || $name =="" || $lastname =="" || $securityNumber == "" || $phonenumber == "" || $town == "" || $zipcode == "" || $address1 == ""){
				echo "Not all fields were entered.";
		}else{
			$today = getRegistrationDate();
			$birthday = fixDate($year, $month, $day);
			$ssn = fixSecurityNumber($year, $month, $day, $securityNumber);
			$result = querySQL("SELECT * FROM users WHERE email = '$email'");//Kontrollerar om eposten redan existerar
			if ($result->num_rows == 0){//Om inte eposten finns så lägger vi in den nya användaren i databasen.
				$query = querySQL("INSERT INTO users (ID, email, passw, regdate, access, birthday, phone, zip, sec, address1, address2, address_co, city, country, first_name, last_name, gender, balance)
									VALUES('','$email', '$password', '$today', '1', '$birthday', '$phonenumber', '$zipcode', '$ssn', '$address1', '$address2','$addressco','$town', 'Sweden', '$name', '$lastname', '', '')");
			}else{
				echo "This email is already registred!";
			}
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
			E-post:
			<input type = "text" name = "email"/><br><br>
			Lösendord:
			<input type = "password" name = "password"/><br><br>
			Bekräfta lösenord:
			<input type = "password" name = "password_bek"/><br><br>
			<hr>
			Namn:
			<input type = "text" name = "name"/><br><br>
			Efternamn:
			<input type = "text" name = "lastname"/><br><br>

			Födelsedatum:
			<select id = "selectBox" name = "year">
				<option value="">YYYY</option>
				<?php
					for ($i = 2016; $i>=1900; $i--){
						echo "<option value=$i>$i</option>";
					}
				?>
			</select>
			<select name = "month">
				<option value="">MM</option>
				<?php
					for ($i = 1; $i<=12; $i++){
						if ($i < 10){
							$i = "0".$i;
						}
						echo "<option value=$i>$i</option>";
					}
				?>
			</select>
			<select name = "day">
				<option value="">DD</option>
				<?php
					for ($i = 1; $i<=31; $i++){
						if ($i < 10){
							$i = "0".$i;
						}
						echo "<option value=$i>$i</option>";
					}
				?>
				
			</select>
			-
			<input type = "text" name = "securityNumber" onkeypress="return isNumber(event)" maxlength = "4" size = "4" /><br><br>
			<input type = "text" name = "orgNr"/><br><br>
			Telefonnummer:
			<input type = "text" name = "phonenumber" onkeypress="return isNumber(event)" maxlength = "16" size = "16" /><br><br>
			<hr>
			Land:
			<select>
				<option value = "sweden">Sverige</option>
			</select><br><br>
			Postort:
			<input type = "text" name = "town"/><br><br>
			Postnummer:
			<input type = "text" name = "zipcode" onkeypress="return isNumber(event)" maxlength = "5" size = "5" /><br><br>
			Address 1:
			<input type = "text" name = "address1"/><br><br>
			Address 2:
			<input type = "text" name = "address2"/><br><br>
			Address CO:
			<input type = "text" name = "addressco"/><br><br>
			<input type = "submit" name = "submit" value = "Registrera mig"/>
			<hr>


			
			
		</form>
	</body>
</html>