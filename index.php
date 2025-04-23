<?php
// index.php

include 'db.php'; // include database connection

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grocery Shopping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>Smart Grocery Store</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="cart.php">🛒 Cart <span class="cart-count">0</span></a></li>
            </ul>
        </nav>
        <div style="clear: both;"></div>
    </div>
</header>

<section class="hero">
    <div class="container">
        <h2>Fresh & Healthy Groceries Delivered!</h2>
        <a href="#products" class="btn">Shop Now</a>
    </div>
</section>

<section class="products" id="products">
    <div class="container">
        <h2>Our Products</h2>
        <div class="product-grid">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₹<?php echo $row['price']; ?></p>
                    <button class="add-to-cart" data-product-id="<?php echo $row['product_id']; ?>">Add to Cart</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2025 Smart Grocery Store</p>
</footer>

<!-- Link to JS -->
<script src="script.js"></script>

</body>
</html>
