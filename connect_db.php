<?php # CONNECT TO MySQL DATABASE.  
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = '';
  $DATABASE_NAME = 'shoppingcart';
  $link = connectToDB($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  function connectToDB($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME) {
    try {
      $val = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);  
      return $val;
    } catch (PDOException $exception) {
      // If there is an error connecting
      exit('You have failed to connect!');
    }
  }
?> 