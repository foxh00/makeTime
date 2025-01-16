<?php
# Function to load
function load( $page = 'login.php' )
{
  $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) ;
  $url = rtrim( $url, '/\\' ) ;
  $url .= '/' . $page ;

  # Execute redirect then quit. 
  header( "Location: $url" ) ; 
  exit() ;
}
# Function to check email and password. 
function validate( $link, $email = '', $pwd = '')
{
  $errors = array() ; 

  # Check email field.
  if ( empty( $email ) ) 
  { $errors[] = 'Enter your email address.' ; } 
  else  { $e = mysqli_real_escape_string( $link, trim( $email ) ) ; }

  # Check password field.
  if ( empty( $pwd ) ) 
  { $errors[] = 'Enter your password.' ; } 
  else { $p = mysqli_real_escape_string( $link, trim( $pwd ) ) ; }

  if ( empty( $errors ) ) 
  {
    $q = "SELECT user_id, first_name, last_name FROM users WHERE email='$e' AND pass='$p'" ;  
    $r = mysqli_query ( $link, $q ) ;
    if ( @mysqli_num_rows( $r ) == 1 ) 
    {
      $row = mysqli_fetch_array ( $r, MYSQLI_ASSOC ) ;
      return array( true, $row ) ; 
    }
    # Or on failure set error message.
    else { $errors[] = 'Email address and password not found.' ; }
  }
  # On failure retrieve error message.
  return array( false, $errors ) ; 
}
?>
