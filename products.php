
<?php
require ('connect_db.php'); 
require ('functions.php'); 
session_start();

// The amounts of products which are visible per page
$num_products_on_each_page = 4;
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $link->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_products = $link->query('SELECT * FROM products')->rowCount();
?>
<?=template_header('Products')?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
            <div class="products content-wrapper">
            <br><h4>Products</h4>
            <p><?=$total_products?> Products</p>
            <div class="products-wrapper">
                <?php foreach ($products as $product): ?>
                    <a href="product.php?id=<?=$product['id']?>" class="product">
                    <img src="<?=$product['img']?>" width="200" height="200" alt="<?=$product['title']?>">
                    <span class="name"><?=$product['title']?></span>
                    <span class="price">
                        &pound;<?=$product['price']?>
                    </span>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="buttons">
                <?php if ($current_page > 1): ?>
                <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
                <?php endif; ?>
                <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
                <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
<?php } else { ?>
    <br><center><h4>Please log on to view the catalogue.</h4></center>
    <?php
} ?>

<?=template_footer('© MKTime 2025')?>