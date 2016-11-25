<?php
	session_start();
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID'])){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
	require "functions.php";
	global $connection;
	include "template/header.php";
	generateHeader('Add Order');
	include "template/footer.php";
	if (isset($_POST["submit"])){
		$email = sanitizeString($_POST['email']);
		$name = sanitizeString($_POST['name']);
		$lastname = sanitizeString($_POST['lastname']);
		$telefonnummer = sanitizeString($_POST['phone']);
		$town = sanitizeString($_POST['town']);
		$zipcode = sanitizeString($_POST['zip']);
		$address1 = sanitizeString($_POST['address1']);
		if ($user_ID == ""){
			echo "Not all fields were entered.";
		}else{
			$query = querySQL("INSERT INTO Orders (payment_option, payment_received, order_placed, discount)
					VALUES ('Faktura', 'FALSE', NOW(), 0)");
			$iid = mysqli_insert_id($connection);
			querySQL("UPDATE Cart SET order_ID = $iid WHERE (user_ID = $user_ID AND order_ID IS NULL)"); 
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

			<h1>Uppgifter:</h1>
			<br>
			<form action ="" method = "POST">
			<div class = "col-md-4">
				<input type = "text" class = "form-control" name = "name" id = "name" placeholder = "Förnamn" >
			</div>
			<div class = "col-md-4">
				<input type = "text" class = "form-control" name = "lastname" id = "lastname" placeholder = "Efternamn" ><br>
			</div>
			<div class = "col-md-2"></div>
			<div class = "col-md-2"></div>
			<div class = "col-md-8">
			<form action="" method = "POST">
				<!--input type="email" class = "form-control" id ="email" name = "email" placeholder="E-post"><br>
				<input type="text" class = "form-control" name = "address1" id = "address1" placeholder="Address"><br>
				<input type = "text" class = "form-control" name = "zip" id = "zip" placeholder = "Postnummer"><br>
				<input type = "text" class = "form-control" name = "town" placeholder = "Ort" id ="city"><br>
				<input type = "text" class = "form-control" name = "phone" id ="phone" placeholder = "Telefonnummer"><br>-->
				<input type = "submit" name = "submit" value="Lägg order" class="btn btn-success btn-block"><br><br>
			</form>
				
			</div>
			</form>
			<div class = "col-md-2"></div>
		</div>
			
	</div>

<?php
	generateFooter();
?>
