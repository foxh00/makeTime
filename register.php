<?php 
  require ('functions.php');

  if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
  {# Connect to the database.
      require ('connect_db.php'); 
      # Initialize an error array.
    $errors = array();

    # Check for the name and email.
    if ( empty( $_POST[ 'first_name' ] ) )
    { $errors[] = 'Enter your first name.' ; }
    else
    { $fn = $_POST[ 'first_name' ] ; }

    if ( empty( $_POST[ 'last_name']))
    { $errors[] = 'Enter your last name.' ; }
    else{
      $ln = $_POST[ 'last_name' ] ;
    }

    if ( empty( $_POST[ 'email']))
    { $errors[] = 'Enter your email.' ; }
    else{
      $e =  $_POST[ 'email' ];
    }

    # Checks for a password and matching input passwords.
    if ( !empty($_POST[ 'pass1' ] ) )
    {
      if ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] )
      { $errors[] = 'Passwords do not match.' ; }
      else
      { $p = $_POST[ 'pass1' ]; }
    }
    else { $errors[] = 'Enter your password.' ; }
    # Check if email address already registered.
    if ( empty( $errors ) )
    {
      $query = "SELECT * FROM users WHERE email='$e' LIMIT 1";  
      $prod_rows = $link->query($query);
			$result = $prod_rows->fetch(PDO::FETCH_ASSOC);

				$count = $prod_rows->rowCount();
                if($count > 0)  
                { 
                  $errors[] = 
                  'Email address already registered. 
                  <a class="alert-link" href="login.php">Sign In Now</a>' ;
                }
              }
    # Register user inserting into 'users' database table.
    if ( empty( $errors ) ) 
    {
      $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date) 
    VALUES ('$fn', '$ln', '$e', '$p', NOW() )";
        if ($link->query($q) === TRUE) {
          echo "New record created successfully";
        }
        header('Location: products.php');
      
  # Close database connection.
      exit();
    }
    # Or report errors.
    else 
    {
      echo '<h4 class="alert-heading" id="err_msg">The following error(s) occurred:</h4>' ;
      foreach ( $errors as $msg )
      { echo " - $msg<br>" ; }
      echo '<p>or please try again.</p></div>';
      # Close database connection.
    }  
  }?>

<?=template_header('Product')?>

<html>
<div class="container">
 <form action="register.php" method="post">
 <label for="inputfirst_name">First Name</label>
	<input type="text" 
	       name="first_name" 
	       class="form-control" 
	       required 
	       placeholder="* First Name" 
	       value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
				
  <label for="inputlast_name">Last Name</label>
	<input type="text" 
	       name="last_name" 
	       class="form-control" 
	       required 
	       placeholder="* Last Name" 
	       value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
			
	<label for="inputemail">Email</label>
	  <input type="email" 
	         name="email" 
	         class="form-control" 
	         required 
	         placeholder="* email@example.com" 
	         value="<?php if (isset($_POST['email'])) 
	           echo $_POST['email']; ?>">
					
			
	<label for="inputpass1">Create New Password</label>
		<input type="password"
		       name="pass1" 
		       class="form-control" 
		       required 
		       placeholder="* Create New Password" 
		       value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
					 
					 
	<label for="inputpass2">Confirm Password</label>
		<input type="password" 
		       name="pass2" 
		       class="form-control" 
		       required 
		       placeholder="* Confirm Password" 
		       value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
           <br>
					
		<input type="submit" 
		       value="Create Account Now">
		</form>
    <!-- closing form -->
    <p><br><br><a href="login.php">Already have an account? Login here.</a></p>
</div>
</html>

<?=template_footer()?>