<?php
require ('connect_db.php'); 
require ('functions.php'); 

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    // Remove the product from the shopping cart
    $sql = "DELETE FROM cartcontents WHERE id=".$_GET['remove'];

    if ($link->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $link->error;
    }
}

$prod_query = "SELECT * FROM cartcontents ORDER BY `id`";
$prod_rows = $link->query($prod_query);
$get_rows = $prod_rows->fetchAll(PDO::FETCH_ASSOC);
$products_in_cart = array();

foreach ($get_rows as $product) {
    $products_in_cart[] = (object) $product;
}

$subtotal = 0.00;
// If there are products in cart
if ($prod_rows->rowCount() >= 1) {
    foreach ($products_in_cart as $product) {
        $subtotal = $subtotal + ($product->price * $product->quantity);
    }
}

if (isset($_POST['update'])) {
    foreach ($products_in_cart as $product) {
        $update_quantity = $_POST['quantity-'.$product->id];
        $sql = "UPDATE cartcontents SET quantity=$update_quantity WHERE id=$product->id";
        if ($link->query($sql) === TRUE) {
            echo "Record updated successfully";
        }
    }
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder'])) {
    if(count($products_in_cart) > 0){
        header('Location: placeorder.php');
    }
}
// Check the session variable for products in cart

?>
<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="cart.php" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products_in_cart)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Your cart is empty!</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products_in_cart as $product): 
                    ?>
                <tr>
                    <td class="img">
                        <a href="product.php?id=<?=$product->id?>">
                            <img src="imgs/<?=$product->img?>" width="50" height="50" alt="<?=$product->title?>">
                        </a>
                    </td>
                    <td>
                        <a href="product.php?id=<?=$product->id?>"><?=$product->title?></a>
                        <br>
                        <a href="cart.php?remove=<?=$product->id?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&pound;<?=$product->price?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product->id?>" value="<?=$product->quantity?>" min="1" max="<?=$product->quantity?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&pound;<?=$product->price * $product->quantity?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&pound;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>