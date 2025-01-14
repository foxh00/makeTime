<?php # CONNECT TO MySQL DATABASE.  
  // Update the details below with your MySQL details
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = '';
  $DATABASE_NAME = 'shoppingcart';
  $link = connectToDB($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  function connectToDB($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME) {
    try {
      $val = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
      echo 'Connected successfully!';  
      return $val;
    } catch (PDOException $exception) {
      // If there is an error with the connection, stop the script and display the error.
      exit('You have failed to connect!');
    }
  }
?> 