<?php
include('../include/db_connect.php'); 
include('../include/head.php'); 
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<?php include('../include/nav.php'); ?>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5 p-4 bg-white shadow rounded" style="max-width: 600px;">
        <h2 class="text-center mb-4">Account Settings</h2>
        <form id="settings-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" pattern="[0-9]{11}" title="Phone number must be 11 digits long and numeric." required>
                <div class="invalid-feedback">Please enter a valid 11-digit numeric phone number.</div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-strength" class="password-strength text-muted"></div>
            </div>
            <div class="form-group">
                <label for="street">Street Address</label>
                <input type="text" class="form-control" id="street" name="street" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City/Municipality</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="barangay">Barangay/District</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" required>
                </div>
            </div>
            <div class="form-group">
                <label for="zip">Postal Code</label>
                <input type="text" class="form-control" id="zip" name="zip" pattern="[0-9]{4}" title="Postal code must be 4 digits." required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
        </form>

        <!-- Button to go back home -->
        <a href="index.html" class="btn btn-secondary btn-block mt-3">Back to Home</a>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                    <p class="mt-3">Settings updated successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 48px;"></i>
                    <p class="mt-3">Please complete the form correctly.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- For the icons -->
</body>
</html>
