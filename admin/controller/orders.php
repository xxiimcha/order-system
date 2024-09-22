<?php
include('../../include/db_connect.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'updateOrderStatus':
            updateOrderStatus($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }

    $conn->close();
}

// Function to update the order status
function updateOrderStatus($conn) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the order status
    $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = '$orderId'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}

?>
