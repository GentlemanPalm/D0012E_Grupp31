  <?php 
  // Database specifications
  $dbhost  = 'localhost';    // Our hostname
  $dbname  = 'paljon-4';   //  name of the database (guess it's paljon4db?)
  $dbuser  = 'root';   // User of the database (root?)
  $dbpass  = '';   // password 
  $appname = "kontorsmaterial.se"; //
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname); // Sets up new mysql connection
  if ($connection->connect_error) die($connection->connect_error); // If unable to connect we end the connection

  function querySQL($query)
  {
	global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
  ?>