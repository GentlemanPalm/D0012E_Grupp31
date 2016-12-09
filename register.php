<?php
	require_once 'functions.php';
	require 'template/header.php';
	require 'template/footer.php';
	generateHeader("Registrera");
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
			$result = querySQL("SELECT * FROM Users WHERE email = '$email'");//Kontrollerar om eposten redan existerar
			if ($result->num_rows == 0){//Om inte eposten finns så lägger vi in den nya användaren i databasen.
				querySQL("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
				$query = querySQL("INSERT INTO Users (email, passw, regdate, access, birthday, phone, zip, sec, address1, city, country, first_name, last_name)
									VALUES('$email', '$password', '$today', '1', '$birthday', '$phonenumber', '$zipcode', '$ssn', '$address1', '$town', 'Sweden', '$name', '$lastname')");
				header("Location: login.php");
			}else{
				echo "This email is already registred!";
			}
		}
	}
?>
<!DOCTYPE html>

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

	<h1>Registrering</h1>
	<div class = "col-xs-4">
		<form action = "" method = "POST" accept-charset="utf-8">
			E-post:
			<input type = "text" class = "form-control" name = "email"/>
			Lösendord:
			<input type = "password" class = "form-control" name = "password"/>
			Bekräfta lösenord:
			<input type = "password" name = "password_bek" class = "form-control"/>
			<hr>
			Namn:
			<input type = "text" name = "name" class = "form-control"/>
			Efternamn:
			<input type = "text" class = "form-control" name = "lastname"/>

			Födelsedatum:
			<select id = "selectBox" class = "form-control" name = "year">
				<option value="">YYYY</option>
				<?php
					for ($i = 2016; $i>=1900; $i--){
						echo "<option value=$i>$i</option>";
					}
				?>
			</select>
			<select name = "month" class = "form-control">
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
			<select name = "day" class = "form-control">
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
			
			<input type = "text" name = "securityNumber" class = "form-control" onkeypress="return isNumber(event)" maxlength = "4" size = "4" />
			Telefonnummer:
			<input type = "text" name = "phonenumber" class = "form-control" onkeypress="return isNumber(event)" maxlength = "16" size = "16" />
			<hr>
			Land:
			<select class = "form-control">
				<option value = "sweden" class = "form-control">Sverige</option>
			</select>
			Postort:
			<input type = "text" name = "town" class = "form-control"/>
			Postnummer:
			<input type = "text" name = "zipcode" class = "form-control" onkeypress="return isNumber(event)" maxlength = "5" size = "5" />
			Address 1:
			<input type = "text" name = "address1" class = "form-control"/><br>
			<input type = "submit" class = "btn btn-lg btn-success" name = "submit" value = "Registrera mig" class = "form-control"/>
			<hr>

			
			
			
		</form>
		</div>
<?php generateFooter();?>