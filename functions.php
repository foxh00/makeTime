<?php
 
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingcart';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error
    	exit('Failed to connect to database!');
    }
}

function template_header($title) {
  $link = pdo_connect_mysql();
  $prod_query = "SELECT * FROM cartcontents ORDER BY `id`";
  $prod_rows = $link->query($prod_query);
  $get_rows = $prod_rows->fetchAll(PDO::FETCH_ASSOC);
  $products_in_cart = array();
  
  foreach ($get_rows as $product) {
      $products_in_cart[] = (object) $product;
  }
  
  $num_items_in_cart = 0;
  // If there are products in cart
  if ($prod_rows->rowCount() >= 1) {
      foreach ($products_in_cart as $product) {
        $num_items_in_cart = $num_items_in_cart + $product->quantity;
      }
  }
    
echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>$title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="headimg.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

  <body>
      <!doctype html>
      <div class="visual-header">
          <div class="visual-header-section">
            <h1>MKTime</h1>
            <h3>Luxury Watches, Luxury Lifestyle</h3>
          </div>
        </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">MKTime Watches</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.html">Home<span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="placeorder.php">Checkout</a>
          </li>
          <div id="cart-items">
            <div class="link-icons">
                              <a href="cart.php">
                                  <i class="fas fa-shopping-cart"></i>
                                  <span>$num_items_in_cart</span>
                              </a>
                          </div>
          </div>
        </ul>
      </div>
    </nav>
                </header>
                <main>
    </html>
EOT;
}
// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year MKTime</p>
            </div>
        </footer>
    </body>
</html>
EOT;
}
?>