<?php
	include "functions.php";
	$error = $email = $password = "";
	
  if (isset($_POST['email']) && isset($_POST['password']))
  {
    $email = sanitizeString($_POST['email']);
    $password = sanitizeString($_POST['password']);
    
    if ($email == "" || $password == "")
        $error = "Not all fields were entered<br>";
    else
    {
      $result = querySQL("SELECT email,passw FROM users
        WHERE email='$email' AND passw='$password'");

      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Username/Password
                  invalid</span><br><br>";
      }
      else
      {
		//Start sessions here.
		header ("Location: http://google.se") ;
      }
    }
  }
?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>Login</h1>
		<form action = "" method = "POST">
			Username: <input type = "text" name = "email"/><br><br>
			Password: <input type = "password" name = "password"/><br><br>
			<input type = "submit" name = "submit" value = "Logga in"/>
		</form>
	
	</body>
</html>