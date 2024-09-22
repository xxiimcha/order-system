<?php
// Include database connection
include('include/db_connect.php');

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_id = $_SESSION['user_id']; // Assumes user is logged in and session has user_id
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $quantity = 1; // Default quantity

    // Insert into cart table
    $sql = "INSERT INTO cart (user_id, product_id, product_name, price, size, quantity) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissdi", $user_id, $product_id, $product_name, $price, $size, $quantity);

    if ($stmt->execute()) {
        echo "Product added to cart successfully.";
        header('Location: cart.php'); // Redirect to cart page
    } else {
        echo "Error adding product to cart: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
