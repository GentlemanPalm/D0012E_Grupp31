  <?php 
  // Database specifications
  $dbhost  = 'utbweb.its.ltu.se';    // Our hostname
  $dbname  = 'paljon4db';   //  name of the database (guess it's paljon4db?)
  $dbuser  = 'paljon-4';   // User of the database (root?)
  $dbpass  = 'Boden1337';   // password 
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