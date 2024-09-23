<?php
include('../include/db_connect.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'fetchMessages':
            fetchMessages($conn);
            break;
        case 'sendMessage':
            sendMessage($conn);
            break;
        case 'fetchOrderList': // New case to fetch the list of not completed orders
            fetchOrderList($conn);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
            break;
    }
    $conn->close();
}

// Function to fetch messages based on user and order number
function fetchMessages($conn) {
    $user_id = $_SESSION['id']; // Assuming the user ID is stored in the session
    $order_number = $_GET['order_number']; // Get the order number from the query parameter

    if (empty($user_id) || empty($order_number)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user or order number.']);
        return;
    }

    $sql = "SELECT * FROM chat_messages WHERE user_id = '$user_id' AND order_number = '$order_number' ORDER BY timestamp DESC";
    $result = $conn->query($sql);

    $messages = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'sender' => $row['sender'],
                'text' => $row['message'],
                'timestamp' => $row['timestamp']
            ];
        }
    }
    echo json_encode(['status' => 'success', 'messages' => $messages]);
}

// Function to send a message
function sendMessage($conn) {
    $user_id = $_SESSION['id'];
    $order_number = $_POST['order_number'];
    $message = $_POST['message'];
    $timestamp = date('Y-m-d H:i:s');

    if (empty($user_id) || empty($order_number) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        return;
    }

    // Insert message into the database
    $sql = "INSERT INTO chat_messages (user_id, order_number, message, timestamp, sender) 
            VALUES ('$user_id', '$order_number', '$message', '$timestamp', 'User')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
    }
}

// Function to fetch the list of not completed orders for the logged-in user
function fetchOrderList($conn) {
    $user_id = $_SESSION['id']; // Assuming the user ID is stored in the session

    if (empty($user_id)) {
        echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
        return;
    }

    // Fetch orders that are not completed
    $sql = "SELECT o.order_number, o.order_date, o.order_status 
            FROM orders o
            LEFT JOIN chat_messages cm ON o.order_number = cm.order_number 
            WHERE o.user_id = '$user_id' AND o.order_status != 'Completed'
            GROUP BY o.order_number
            ORDER BY o.order_date DESC";

    $result = $conn->query($sql);

    $orders = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = [
                'order_number' => $row['order_number'],
                'order_date' => $row['order_date'],
                'status' => $row['order_status']
            ];
        }
    }
    echo json_encode(['status' => 'success', 'orders' => $orders]);
}
?>
