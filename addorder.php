<?php
	session_start();
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID'])){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
	require "connect.php";
	global $connection;
	include "template/header.php";
	generateHeader('Add Order');
	include "template/footer.php";
	
?>
	<script src ="cart.js"></script>
	<script>
		window.onload = function(){
			loadCart('<?php echo $user_ID;?>');
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
			<div class = "col-md-4">
				<input type = "text" class = "form-control" name = "name" placeholder = "Förnamn" >
			</div>
			<div class = "col-md-4">
				<input type = "text" class = "form-control" name = "lastname" placeholder = "Efternamn" ><br>
			</div>
			<div class = "col-md-2"></div>
			<div class = "col-md-2"></div>
			<div class = "col-md-8">
				<input type="email" class = "form-control" name = "email" placeholder="E-post"><br>
				<input type="text" class = "form-control" name = "address" placeholder="Address"><br>
				<input type = "text" class = "form-control" name = "postnummer" placeholder = "Postnummer"><br>
				<input type = "text" class = "form-control" name = "ort" placeholder = "Ort"><br>
				<input type = "text" class = "form-control" name = "telefonnummer" placeholder = "Telefonnummer"><br>
				<input type = "submit" name = "submit" value="Lägg order" class="btn btn-success btn-block"><br><br>
				
			</div>
			<div class = "col-md-2"></div>
		</div>
			
	</div>

<?php
	generateFooter();
?>
