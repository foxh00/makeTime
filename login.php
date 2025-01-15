
<?php 
include ( './nav.php' ) ;
# Displays any error messages if there is an error.
if ( isset( $errors ) && !empty( $errors ) )
{
 echo '<p id="err_msg">Oops! There was a problem:<br>' ;
 foreach ( $errors as $msg ) { echo " - $msg<br>" ; }
 echo 'Please try again or <a href="register.php">Register</a></p>' ;
}
?>
<html>
<div class="container">
<form action="login_action.php" method="post">
  <label for="inputemail">Enter Your Email</label>
  <input type="text" 
		 name="email" 
		 class="form-control" 
		 required 
		 placeholder="* Enter Email"> 
		
		 
  <label for="inputpassword">Enter Your Password</label>
  <input type="password" 
		 name="pass"  
	     class="form-control" 
		 required 
	     placeholder="* Enter Password">
		 <br>
		
  <input type="submit" value="Login">
</form>
<!-- closing form -->
<p><br><br><a href="register.php">No account? Register here.</a></p>
</div>
</html>
