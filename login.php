
<?php 
require ('functions.php'); 
require ('connect_db.php'); 
// Displays any error messages if there is an error.
try  
 {  
      $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = "Incorrect username or password! Please try again."; ;  
           }  
           else  
           {
                // User authentication  
				$usr = $_POST["username"];
                $query = "SELECT * FROM users WHERE email='$usr' LIMIT 1";  
                $prod_rows = $link->query($query);
				$result = $prod_rows->fetch(PDO::FETCH_ASSOC);

				$count = $prod_rows->rowCount();
                if($count > 0)  
                {  
                    //check password
                    if ($_POST["password"] == $result['pass']) {
						session_start();
                        $_SESSION["loggedin"] = $_POST["username"];
						header('Location: products.php');
						exit();
                    } else {
                         $message = "Incorrect username or password! Please try again."; 
                    } 
                }
                else  
                {  
					$message = "Incorrect username or password! Please try again."; 
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 ?>

<?=template_header('Product')?>

<html>
<div class="container">
<form action="" method="post">
  <label for="inputusername">Enter Your Username</label>
  <input type="text" 
		 name="username" 
		 class="form-control" 
		 required 
		 placeholder="* Enter Username"> 
		
		 
  <label for="inputpassword">Enter Your Password</label>
  <input type="password" 
		 name="password"  
	     class="form-control" 
		 required 
	     placeholder="* Enter Password">
		 <br>
		
  <input type="submit" value="Login" name="login">
</form>
<!-- closing form -->
<p><br><br><a href="register.php">No account? Register here.</a></p>
</div>
</html>
<?=template_footer()?>