<?php
include('include/db_connect.php');

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['product_id']) && isset($_GET['size'])) {
    $product_id = $_GET['product_id'];
    $size = $_GET['size'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $product_name = $product['name'];
        $price = $product['price'];
        $description = $product['description'];
    } else {
        echo "Product not found.";
        exit();
    }

    // Process the order (you can add your own logic here)
    echo "<h1>Checkout</h1>";
    echo "<p>Product: $product_name</p>";
    echo "<p>Size: $size</p>";
    echo "<p>Price: ₱$price</p>";
    echo "<form method='POST' action='process_order.php'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='size' value='$size'>";
    echo "<button type='submit'>Place Order</button>";
    echo "</form>";
} else {
    echo "No product selected.";
}
?>
