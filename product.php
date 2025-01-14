<?php 
    require ('functions.php'); 
    require ('connect_db.php'); 
    // Check to make sure the id parameter is specified in the URL
    if (isset($_GET['id'])) {
        // Prepare statement and execute, prevents SQL injection
        $stmt = $link->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        // Fetch the product from the database and return the result as an Array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if the product exists (array is not empty)
        if (!$product) {
            // Simple error to display if the id for the product doesn't exists (array is empty)
            exit('Product does not exist!');
        }
    } else {
        // Simple error to display if the id wasn't specified
        exit('Product does not exist!');
    }

  if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
  {
      # Initialize an error array.

    $errors = array();

    $ti = $product['title'];
    $de = $product['description'];
    $p = $product['price'];
    $qu = $_POST['item_quantity'];
    $i = $product['img'];
    $g = $product['gender'];
    $pi = $product['id'];

    # On success register user inserting into 'users' database table.
    if ( empty( $errors ) ) 
    {
    $query_title = "SELECT * FROM cartcontents WHERE title = '$ti'";
    $already_present = $link->query($query_title);

    if($already_present->rowCount() < 1){
        $q = "INSERT INTO cartcontents (title, item_description, price, quantity, img, date_added, gender, product_id) 
        VALUES ('$ti', '$de', '$p', '$qu', '$i', NOW(), '$g', '$pi' )";
    
          if ($link->query($q) === TRUE) {
            echo "New record created successfully";
          }
        }else{
            $item_quantity = $_POST['item_quantity'];
            $update_cart = "UPDATE cartcontents SET quantity=quantity+'$item_quantity' WHERE title='$ti'";
            $increment_count = $link->query($update_cart);
        }
    }
    # Or report errors.
    else 
    {
      echo '<h4 class="alert-heading" id="err_msg">The following error(s) occurred:</h4>' ;
      foreach ( $errors as $msg )
      { echo " - $msg<br>" ; }
      echo '<p>or please try again.</p></div>';
    }  
  }?>

<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="imgs/<?=$product['img']?>" width="500" height="500" alt="<?=$product['title']?>">
    <div>
        <h1 class="name"><?=$product['title']?></h1>
        <span class="price">
            &pound;<?=$product['price']?>
        </span>
        <form action="" method="post">
            <input type="number" name="item_quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product['description']?>
        </div>
    </div>
</div>

<?=template_footer()?>