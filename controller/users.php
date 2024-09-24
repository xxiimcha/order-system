<?php
include('../include/db_connect.php'); 

// Check if the request is POST and the action parameter is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'updateprofile':
            updateProfile();
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
}

// Function to update profile
function updateProfile() {
    global $conn;

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);

    // If the password is not empty, hash it
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

    // Construct the base update query
    $query = "UPDATE users SET 
                username = '$username', 
                email = '$email', 
                name = '$name', 
                phone = '$phone', 
                street = '$street', 
                city = '$city', 
                barangay = '$barangay', 
                zip = '$zip'";

    // Include password update if provided
    if (!empty($password)) {
        $hashedPassword = mysqli_real_escape_string($conn, $hashedPassword);
        $query .= ", password = '$hashedPassword'";
    }

    $query .= " WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Update the session with the new values
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['street'] = $street;
        $_SESSION['city'] = $city;
        $_SESSION['barangay'] = $barangay;
        $_SESSION['zip'] = $zip;

        echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating profile: ' . mysqli_error($conn)]);
    }
}
?>
