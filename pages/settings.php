<?php
include('../include/db_connect.php'); 
include('../include/head.php'); 
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<link rel="stylesheet" href="css/settings.css">
<?php include('../include/nav.php'); ?>

<body>
    <div class="account-settings-container">
        <h2>Account Settings</h2>
        <form id="settings-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="custom-input" id="username" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="custom-input" id="name" name="name" value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="custom-input" id="phone" name="phone" pattern="[0-9]{11}" title="Phone number must be 11 digits long and numeric." value="<?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : ''; ?>" required>
                <div class="invalid-feedback">Please enter a valid 11-digit numeric phone number.</div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="custom-input" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="custom-input" id="password" name="password">
                <div id="password-strength" class="password-strength"></div>
            </div>
            <div class="form-group">
                <label for="street">Street Address</label>
                <input type="text" class="custom-input" id="street" name="street" value="<?php echo isset($_SESSION['street']) ? htmlspecialchars($_SESSION['street']) : ''; ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group-half">
                    <label for="city">City/Municipality</label>
                    <input type="text" class="custom-input" id="city" name="city" value="<?php echo isset($_SESSION['city']) ? htmlspecialchars($_SESSION['city']) : ''; ?>" required>
                </div>
                <div class="form-group-half">
                    <label for="barangay">Barangay/District</label>
                    <input type="text" class="custom-input" id="barangay" name="barangay" value="<?php echo isset($_SESSION['barangay']) ? htmlspecialchars($_SESSION['barangay']) : ''; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="zip">Postal Code</label>
                <input type="text" class="custom-input" id="zip" name="zip" pattern="[0-9]{4}" title="Postal code must be 4 digits." value="<?php echo isset($_SESSION['zip']) ? htmlspecialchars($_SESSION['zip']) : ''; ?>" required>
            </div>

            <button type="submit" class="btn-primary">Save Changes</button>
        </form>

        <!-- Button to go back home -->
        <a href="index.html" class="btn-secondary">Back to Home</a>
    </div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- For the icons -->
<script>
    // Wait until the document is fully loaded
    $(document).ready(function () {
        // Attach a submit event handler to the form
        $('#settings-form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Collect form data using FormData
            const formData = new FormData(this);
            formData.append('id', <?php echo $_SESSION['id']; ?>); // Assuming user_id is stored in session

            // Perform an AJAX request
            $.ajax({
                url: '../controller/users.php?action=updateprofile',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Profile updated successfully!');
                        location.reload(); // Reload the page upon success
                    } else {
                        alert('Failed to update profile: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred while updating the profile.');
                }
            });
        });
    });
</script>


</body>
</html>
