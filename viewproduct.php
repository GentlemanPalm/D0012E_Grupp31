<?php
session_start();

require_once 'functions.php';
require 'template/header.php';
require 'template/footer.php';

$valid = isset($_GET["id"]);
$id = sanitizeString($_GET["id"]);
$desc = $title = $price = "";
$cursor = NULL;
$val = NULL;

if ($valid) {
	$cursor = querySQL("SELECT * FROM Products WHERE ID = $id");
	if ($cursor->num_rows == 0) {
		$valid = false; // Produkten kunde inte hittas
	} else {
		$val = $cursor->fetch_assoc();
	}
}


generateHeader($valid ? $val["name"] : "Proukten kunde inte hittas");
?>
<script>
	function isNumber(evt) { // Emils script från register.php. Borde vi flytta det till en egen fil istället för copy paste?
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>
<script src="addtocart.js"></script>
<?php

if (!$valid) {
	?>
	<h2 class="text-danger">Produkten du letar efter kunde inte hittas!</h2>
	<?php
} else {
	$price = $val["current_price"] + $val["current_price"] * $val["vat"];
	?>
	 <h2><?=$val["name"]?></h2>
	 <p>Lagersaldo: <div id = "show_quantity"></div></p>
	 <p>Pris: <?=$price?></p>
	 <p><?=$val["description"]?></p>
	 	Antal: <input type = "text" value ="1" id ="quantity" name = "quantity" onkeypress="return isNumber(event)" maxlength = "4" size = "4" /><br><br>
	 	<button type="submit" class="btn btn-success" onClick="addToCart(<?php echo $id; ?>)">
	 		Lägg till i varukorgen <span class="glyphicon glyphicon-shopping-cart"></span>
	 	</button>
		<div id="txtHint"></div>
	<?php
}
generateFooter();