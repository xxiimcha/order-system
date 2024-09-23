<?php
include('../../include/db_connect.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'updateOrderStatus':
            updateOrderStatus($conn);
            break;
        case 'getOrderStatus':
            getOrderStatus($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }

    $conn->close();
}

// Function to update the order status
function updateOrderStatus($conn) {
    if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
        echo json_encode(['success' => false, 'message' => 'Order ID and Status are required.']);
        return;
    }

    $orderId = $conn->real_escape_string($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Validate status input
    $validStatuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Completed'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
        return;
    }

    // Prepare the SQL query to update the order status
    $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = '$orderId'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating status: ' . $conn->error]);
    }
}

// Function to get the current order status
function getOrderStatus($conn) {
    if (!isset($_GET['order_number'])) {
        echo json_encode(['success' => false, 'message' => 'Order number is required.']);
        return;
    }

    $orderNumber = $conn->real_escape_string($_GET['order_number']);

    // Prepare the SQL query to fetch the current order status
    $sql = "SELECT order_status FROM orders WHERE order_number = '$orderNumber'";

    // Execute the query
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'status' => $row['order_status']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found or unable to retrieve status.']);
    }
}
?>
