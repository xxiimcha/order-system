<?php
include '../include/db_connect.php';

// Function to ensure a default admin account exists
function createDefaultAdmin($conn) {
    $defaultAdminUsername = 'admin';
    $defaultAdminEmail = 'admin@example.com';
    $defaultAdminPassword = password_hash('admin123', PASSWORD_BCRYPT); // Default password is 'admin123'
    $role = 'admin';

    // Check if the default admin account already exists
    $sql_check = "SELECT * FROM users WHERE role='admin' LIMIT 1";
    $result = $conn->query($sql_check);

    if ($result->num_rows == 0) {
        // Create the default admin account
        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES ('$defaultAdminUsername', '$defaultAdminEmail', '$defaultAdminPassword', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Default admin account created successfully.<br>";
        } else {
            echo "Error creating default admin account: " . $conn->error . "<br>";
        }
    }
}

// Function for customer signup
function signup($conn) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'customer'; // Default role is 'customer'

    // Check if the email or username already exists
    $sql_check = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['email'] == $email) {
            echo "Error: Email already exists.";
        } elseif ($row['username'] == $username) {
            echo "Error: Username already exists.";
        }
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "New customer account created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function for user login
function login($conn) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            foreach ($row as $key => $value) {
                $_SESSION[$key] = $value;
            }

            if ($_SESSION['role'] == 'admin') {
                echo "admin";
            } else {
                echo "customer";
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username.";
    }
}

// Create the default admin account if it doesn't exist
createDefaultAdmin($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch ($action) {
        case 'signup':
            signup($conn);
            break;

        case 'login':
            login($conn);
            break;

        default:
            echo "Invalid action.";
            break;
    }

    $conn->close();
}
?>
