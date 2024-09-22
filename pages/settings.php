<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #160e0e;
            font-family: Arial, sans-serif;
         
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            color: black; /* Added white text color */
        }
        h2 {
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .password-strength {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Account Settings</h2>
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

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <!-- Button to go back home -->
        <a href="index.html" class="btn btn-secondary mt-3">Back to Home</a>
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
                <div class="modal-body">
                    Settings updated successfully!
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
                <div class="modal-body">
                    Please complete the form correctly.
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
    <script>
        function checkPasswordStrength(password) {
            let strengthText = '';
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[\W]/.test(password)) strength += 1;

            switch (strength) {
                case 1:
                case 2:
                    strengthText = 'Weak';
                    break;
                case 3:
                    strengthText = 'Moderate';
                    break;
                case 4:
                case 5:
                    strengthText = 'Strong';
                    break;
                default:
                    strengthText = '';
            }

            return strengthText;
        }

        $('#password').on('input', function() {
            const password = $(this).val();
            const strengthText = checkPasswordStrength(password);
            $('#password-strength').text(`Password Strength: ${strengthText}`);
        });

        $('#settings-form').on('submit', function(e) {
            e.preventDefault();

            if (this.checkValidity()) {
                // Show success modal
                $('#successModal').modal('show');

                // Placeholder for server-side email notification
                // Example: Send AJAX request to server to handle form data and send email
                // $.post('/update-settings', $(this).serialize(), function(response) {
                //     console.log('Email sent to customer:', response);
                // });

                // Clear form after submission
                this.reset();
                $('#password-strength').text('');
            } else {
                // Show error modal
                $('#errorModal').modal('show');
            }
        });
    </script>
</body>
</html>
