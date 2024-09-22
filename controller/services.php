<?php
include('../include/db_connect.php');

function handleBooking() {
    global $conn;

    // Extract data from the POST request
    $streetName = $_POST['streetName'];
    $municipality = $_POST['municipality'];
    $city = $_POST['city'];
    $eventType = $_POST['eventType'];
    $numberOfPeople = $_POST['numberOfPeople'];
    $foodPreference = $_POST['foodPreference'];
    $contactNumber = $_POST['contactNumber'];
    $date = $_POST['date'];
    $email = $_POST['email'];

    // Validate the required fields
    if (empty($streetName) || empty($municipality) || empty($city) || empty($eventType) || empty($numberOfPeople) || empty($foodPreference) || empty($contactNumber) || empty($date) || empty($email)) {
        respondWithJson(['success' => false, 'message' => 'All fields are required.']);
        return;
    }

    // SQL Query for insertion
    $sql = "INSERT INTO bookings (street_name, municipality, city, event_type, number_of_people, food_preference, contact_number, event_date, email)
            VALUES ('$streetName', '$municipality', '$city', '$eventType', '$numberOfPeople', '$foodPreference', '$contactNumber', '$date', '$email')";

    if (mysqli_query($conn, $sql)) {
        respondWithJson(['success' => true]);
    } else {
        respondWithJson(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }
}

// Function to send a JSON response
function respondWithJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}

// Main switch logic to handle different actions
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'booking':
        handleBooking();
        break;
    default:
        respondWithJson(['success' => false, 'message' => 'Invalid action specified.']);
        break;
}
?>
