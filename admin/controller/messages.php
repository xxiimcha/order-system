<?php
include('../../include/db_connect.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'sendMessage':
            sendMessage($conn);
            break;
        case 'getMessages':
            getMessages($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }

    // Close the database connection
    $conn->close();
}

// Function to send a message
function sendMessage($conn) {
    $userId = $_POST['user_id'];
    $orderNumber = $_POST['order_number'];
    $message = $_POST['message'];
    $sender = $_POST['sender'];

    if (empty($userId) || empty($orderNumber) || empty($message) || empty($sender)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    // Insert the message into the database
    $sql = "INSERT INTO chat_messages (user_id, order_number, sender, message, timestamp) 
            VALUES ('$userId', '$orderNumber', '$sender', '$message', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send the message: ' . $conn->error]);
    }
}

// Function to fetch chat messages
function getMessages($conn) {
    $userId = $_GET['user_id'];
    $orderNumber = $_GET['order_number'];

    if (empty($userId) || empty($orderNumber)) {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID or order number.']);
        exit;
    }

    $sql = "SELECT sender, message, timestamp 
            FROM chat_messages 
            WHERE user_id = '$userId' AND order_number = '$orderNumber' 
            ORDER BY timestamp ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode(['success' => true, 'messages' => $messages]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No messages found.']);
    }
}
?>
