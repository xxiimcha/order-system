<?php
include('../include/db_connect.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'ordernow':
            orderNow($conn);
            break;
        case 'getUserOrders':
            getOrders($conn);
            break;
        default:
            echo "Invalid action.";
            break;
    }

    // Close the database connection
    $conn->close();
}

// Function to handle placing an order
function orderNow($conn) {
    // Retrieve POST data sent from the AJAX request
    $itemName = $_POST['itemName'];
    $quantity = $_POST['quantity'];
    $orderType = $_POST['orderType'];
    $paymentMode = $_POST['paymentMode'];
    $deliveryAddress = isset($_POST['deliveryAddress']) ? $_POST['deliveryAddress'] : null;
    $userId = $_POST['userId'];

    // Generate a randomized order number with the prefix "LF" followed by 4 random numbers
    $orderNumber = 'LF' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

    // Ensure data is validated before inserting into the database
    if (empty($itemName) || empty($quantity) || empty($userId)) {
        echo "Invalid data. Please try again.";
        exit;
    }

    // Prepare the SQL query to insert the order data
    $sql = "INSERT INTO orders (order_number, user_id, item_name, quantity, order_type, payment_mode, delivery_address, order_date) 
            VALUES ('$orderNumber', '$userId', '$itemName', '$quantity', '$orderType', '$paymentMode', " . 
            ($deliveryAddress ? "'$deliveryAddress'" : "NULL") . ", NOW())";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully! Your order number is: " . $orderNumber;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to get orders based on the user ID
function getOrders($conn) {
    // Retrieve the userId from the session
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    // Check if userId is available
    if (empty($userId)) {
        echo json_encode(['success' => false, 'error' => 'Invalid user ID.']);
        exit;
    }

    // Prepare the SQL query to fetch orders for the specified user
    $sql = "SELECT * FROM orders WHERE user_id = '$userId' ORDER BY order_date DESC";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        if ($result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            // Return success response with orders
            echo json_encode(['success' => true, 'orders' => $orders]);
        } else {
            // Return a success response with an empty orders array
            echo json_encode(['success' => true, 'orders' => [], 'message' => 'No orders found for this user.']);
        }
    } else {
        // Return error response if the query fails
        echo json_encode(['success' => false, 'error' => 'Error fetching orders: ' . $conn->error]);
    }
}

?>
