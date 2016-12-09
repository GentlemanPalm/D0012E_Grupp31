<?php
	require_once 'functions.php';
	require 'template/header.php';
	require 'template/footer.php';
	generateHeader("Skapa kategori");
	if ($_SESSION['user_ID'] == ""){
		header("Location:login.php");
	}
	$email = $orgnr = $password = $name = $lastname = $securityNumber = $phonenumber = $town = $zipcode = $address1 = $address2 = $addressco = "";
	//Undviker SQL-injection
	if (isset($_POST["submit"])){
		global $connection;
		$title = sanitizeString($_POST["title"]);
		$img = $connection->real_escape_string($_POST["img"]);

		//Kontrollerar om alla fällt är ifyllda.
		if ($title == "" || $img == ""){
				echo "Not all fields were entered correctly.";
		}else{
			$query = querySQL("INSERT INTO Categories(title, img_path) VALUES ('$title', '$img')");
		}
	}

?>
	<h1>Registrering</h1>
		<form action = "" method = "POST">
			Kategorins namn:
			<input type = "text" name = "title"/><br><br>
			
			URL till standardbild:
			<input type = "text" name = "img"/><br><br>


			<input type = "submit" name = "submit" value = "Lägg till kategori!"/>
			<hr>			
		</form>
<?php
generateFooter();
?>