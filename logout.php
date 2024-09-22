<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page (or any other page)
header("Location: login.php");
exit(); // Ensure the script stops executing after redirection
?>
