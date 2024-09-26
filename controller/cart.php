<?php
session_start();
include('../include/db_connect.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getUserCartItems':
        getUserCartItems($conn);
        break;

    case 'removeCartItem':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            removeCartItem($conn);
        }
        break;

    case 'checkout':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            checkout($conn);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

mysqli_close($conn);

// Function to fetch user cart items
function getUserCartItems($conn) {
    $user_id = $_SESSION['id'];
    $query = "SELECT * FROM cart_items WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    $cartItems = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }

    echo json_encode(['success' => true, 'cartItems' => $cartItems]);
}

// Function to remove an item from the cart
function removeCartItem($conn) {
    $cartItemId = $_POST['id'];
    $deleteQuery = "DELETE FROM cart_items WHERE id = $cartItemId";

    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove item']);
    }
}
// Function to handle the checkout process
function checkout($conn) {
    $user_id = $_SESSION['id'];
    
    // Fetch cart items for the user
    $cartQuery = "SELECT * FROM cart_items WHERE user_id = $user_id";
    $cartResult = mysqli_query($conn, $cartQuery);

    if (mysqli_num_rows($cartResult) > 0) {
        $totalAmount = 0;
        $cartItems = [];

        while ($row = mysqli_fetch_assoc($cartResult)) {
            $cartItems[] = $row;
            $totalAmount += $row['total'];
        }

        // Generate a unique order number (you can change this logic as needed)
        $orderNumber = 'LF' . rand(1000, 9999);

        // Insert into orders table
        $orderDate = date('Y-m-d H:i:s');
        $orderType = 'Pickup';  // Assuming 'Pickup' as default; change as needed
        $paymentMode = 'Cash';  // Assuming 'Cash' as default; change as needed
        $orderStatus = 'Pending'; // Set initial status to 'Pending'
        $deliveryAddress = NULL; // Assuming null as default; change as needed
        
        // Since you have only one item name in your orders table structure, let's get the first item's name and quantity
        $itemName = $cartItems[0]['product_name'];
        $quantity = $cartItems[0]['quantity'];

        $insertOrderQuery = "INSERT INTO orders (order_number, user_id, item_name, quantity, total_amount, order_type, payment_mode, delivery_address, order_status, order_date) 
                             VALUES ('$orderNumber', $user_id, '$itemName', $quantity, $totalAmount, '$orderType', '$paymentMode', NULL, '$orderStatus', '$orderDate')";
        
        if (mysqli_query($conn, $insertOrderQuery)) {
            // Get the inserted order ID
            $orderId = mysqli_insert_id($conn);

            // Clear the user's cart after the order is placed
            $clearCartQuery = "DELETE FROM cart_items WHERE user_id = $user_id";
            mysqli_query($conn, $clearCartQuery);

            echo json_encode(['status' => 'success', 'message' => 'Checkout completed successfully', 'order_id' => $orderId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create order']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Your cart is empty']);
    }
}

?>
