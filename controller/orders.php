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
        case 'addtocart': // New action for adding to the cart
            addToCart($conn);
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
    $totalAmount = $_POST['totalAmount']; // Retrieve the total amount from the request

    // Generate a randomized order number with the prefix "LF" followed by 4 random numbers
    $orderNumber = 'LF' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

    // Ensure data is validated before inserting into the database
    if (empty($itemName) || empty($quantity) || empty($userId) || empty($totalAmount)) {
        echo "Invalid data. Please try again.";
        exit;
    }

    // Escape strings to prevent SQL injection
    $itemName = $conn->real_escape_string($itemName);
    $deliveryAddress = $conn->real_escape_string($deliveryAddress);

    // Prepare the SQL query to insert the order data
    $sql = "INSERT INTO orders (order_number, user_id, item_name, quantity, order_type, payment_mode, delivery_address, total_amount, order_date) 
            VALUES ('$orderNumber', '$userId', '$itemName', '$quantity', '$orderType', '$paymentMode', " . 
            ($deliveryAddress ? "'$deliveryAddress'" : "NULL") . ", '$totalAmount', NOW())";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully! Your order number is: " . $orderNumber;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to add an item to the cart
function addToCart($conn) {
    // Retrieve POST data sent from the AJAX request
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Ensure user is logged in
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    if (empty($userId)) {
        echo json_encode(['status' => 'error', 'message' => 'You need to be logged in to add items to the cart.']);
        exit;
    }

    // Fetch item details from the products table
    $query = "SELECT * FROM products WHERE id = '$itemId'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
        $productName = $item['name'];
        $price = $item['price'];
        $total = $price * $quantity;

        // Check if the item already exists in the cart for this user
        $checkCartQuery = "SELECT * FROM cart_items WHERE user_id = '$userId' AND product_id = '$itemId'";
        $checkCartResult = $conn->query($checkCartQuery);

        if ($checkCartResult && $checkCartResult->num_rows > 0) {
            // Update the existing item quantity and total
            $existingCartItem = $checkCartResult->fetch_assoc();
            $newQuantity = $existingCartItem['quantity'] + $quantity;
            $newTotal = $newQuantity * $price;

            $updateQuery = "UPDATE cart_items 
                            SET quantity = '$newQuantity', total = '$newTotal' 
                            WHERE id = '{$existingCartItem['id']}'";

            if ($conn->query($updateQuery) === TRUE) {
                echo json_encode(['status' => 'success', 'message' => 'Item quantity updated in cart.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating item in cart: ' . $conn->error]);
            }
        } else {
            // Insert a new item into the cart
            $insertQuery = "INSERT INTO cart_items (user_id, product_id, product_name, price, quantity, total) 
                            VALUES ('$userId', '$itemId', '$productName', '$price', '$quantity', '$total')";

            if ($conn->query($insertQuery) === TRUE) {
                echo json_encode(['status' => 'success', 'message' => 'Item added to cart successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error adding item to cart: ' . $conn->error]);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
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
