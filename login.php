<?php
	include "functions.php";
	require 'template/header.php';
	require 'template/footer.php';
	generateHeader("Logga in");
	$error = $email = $password = "";

	
  if (isset($_POST['email']) && isset($_POST['password']))
  {
    $email = sanitizeString($_POST['email']);
    $password = sanitizeString($_POST['password']);
    
    if ($email == "" || $password == "")
        $error = "Not all fields were entered<br>";
    else
    {
      $result = querySQL("SELECT email,passw,id,access FROM Users
        WHERE email='$email' AND passw='$password'");
		
      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Username/Password
                  invalid</span><br><br>";
      }
      else
      {
		$val = $result->fetch_assoc();
		$_SESSION['user_ID'] = $val['id'];
		$_SESSION['access'] = $val['access'];
		//Start sessions here.
		header ("Location: browseproducts.php") ;
      }
    }
  }
?>
		<h1>Logga in</h1>
		<form action = "" method = "POST">
			<div class = "col-xs-4">
				Användarnamn: <input class = "form-control" type = "text" name = "email" placeholder = "Epost"/>
				Lösenord: <input  class = "form-control" type = "password" name = "password" placeholder = "Lösenord"/>
<br>				<input type = "submit" name = "submit" value = "Logga in" class = "btn btn-lg btn-success"/><br>
				<a href="register.php">Eller registrera dig</a>
			</div>
		</form>

<?php
generateFooter();?>