<?php
include('include/db_connect.php');

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    // You would process the payment and order details here
    // For simplicity, we'll assume the order is successful and redirect the user to an order confirmation page

    echo "Order placed successfully.";
    header('Location: order_confirmation.php');
    exit();
}
?>
