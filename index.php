<?php
	session_start();
		$user_ID = $session_ID = "";
		if(isset($_SESSION['user_ID'])){
			$user_ID = $_SESSION['user_ID'];
		}else{
			$session_ID = session_ID();
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8"> <!-- Taken from W3Schools Bootstrap tutorial -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="cart.js"></script>
  <script>
	window.onload = function(){
			loadCart('<?php echo $user_ID;?>');
	}
	</script>
</head>
<body>
<div class="jumbotron">
	<h1>Simple Design Mockup</h1>
	<p>Just trying to make some bloody prototype</p>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2">
			<h3>Kategori</h3>
			<ul class="list-group">
				<li class="list-group-item">Pennor <span class="badge">14</span></li>
				<li class="list-group-item">Bläck <span class="badge">8</span></li>
				<li class="list-group-item">Papper <span class="badge">5</span></li>
				<li class="list-group-item">Skrivare <span class="badge">3</span></li>
			</ul>
		</div>
		<div class="col-sm-7">
			<h2>Productbeskrivning</h2>
			<img src="https://pixabay.com/static/uploads/photo/2012/04/14/16/36/pencil-34532_960_720.png" alt="Världens bästa penna!" height = "200px" />
			<p>Här har vi världens bästa penna. För bra för att vara verklig...</p>
			
		</div>
		<div class="col-sm-3">
			<h2>Cart</h2>
			<div class = "table-responsive">
				<table id = "cart" class ="table table-striped">
			

				</table>
			</div>
			<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span> Kassa</button>
		</div>
	</div>
</div>

</body>
</html>