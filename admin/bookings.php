<?php
include('../include/db_connect.php'); 
include('include/header.php'); 
?>

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Manage Bookings</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Bookings</li>
            </ol>

            <!-- Bookings List Table -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-check me-1"></i>
                    Booking List
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Date</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="booking-list">
                            <?php
                            // Retrieve bookings from the database
                            $sql = "SELECT * FROM bookings";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $address = "{$row['street_name']}, {$row['municipality']}, {$row['city']}";
                                    echo "<tr id='booking-row-{$row['id']}'>
                                            <td>{$row['id']}</td>
                                            <td>{$row['event_date']}</td>
                                            <td>{$address}</td>
                                            <td id='status-{$row['id']}'>{$row['status']}</td>
                                            <td>
                                                <button class='btn btn-info btn-sm' onclick='viewDetails({$row['id']})'>View Details</button>
                                                <button onclick='updateBookingStatus({$row['id']}, \"Approved\")' class='btn btn-sm btn-success'>Approve</button>
                                                <button onclick='updateBookingStatus({$row['id']}, \"Rejected\")' class='btn btn-sm btn-danger'>Reject</button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No bookings found.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- View Details Modal -->
            <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewDetailsModalLabel">Booking Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Event Type:</strong> <span id="eventType"></span></p>
                            <p><strong>Number of People:</strong> <span id="numberOfPeople"></span></p>
                            <p><strong>Food Preference:</strong> <span id="foodPreference"></span></p>
                            <p><strong>Contact Number:</strong> <span id="contactNumber"></span></p>
                            <p><strong>Email:</strong> <span id="email"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Customize Menu Modal -->
            <div class="modal fade" id="customizeMenuModal" tabindex="-1" aria-labelledby="customizeMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customizeMenuModalLabel">Customize Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="menuForm">
                                <input type="hidden" id="bookingId" name="booking_id">
                                <div class="mb-3">
                                    <label for="menuItems" class="form-label">Menu Items</label>
                                    <textarea class="form-control" id="menuItems" name="menu_items" rows="5" placeholder="Enter menu items separated by commas"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Menu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->

<script>
$(document).ready(function() {
    // Approve or Reject booking status
    window.updateBookingStatus = function(bookingId, status) {
        $.ajax({
            url: 'controller/bookings.php',
            type: 'POST',
            data: {
                action: 'updateStatus',
                booking_id: bookingId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    $('#status-' + bookingId).text(status);
                    toastr.success('Booking status updated to ' + status);
                } else {
                    toastr.error(response.message || 'Failed to update booking status');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('An error occurred while updating booking status.');
            }
        });
    };

    // View Details
    window.viewDetails = function(bookingId) {
        $.ajax({
            url: 'controller/bookings.php',
            type: 'POST',
            data: {
                action: 'getDetails',
                booking_id: bookingId
            },
            success: function(response) {
                if (response.success) {
                    $('#eventType').text(response.data.event_type);
                    $('#numberOfPeople').text(response.data.number_of_people);
                    $('#foodPreference').text(response.data.food_preference);
                    $('#contactNumber').text(response.data.contact_number);
                    $('#email').text(response.data.email);
                    $('#viewDetailsModal').modal('show');
                } else {
                    toastr.error(response.message || 'Failed to load booking details');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('An error occurred while fetching booking details.');
            }
        });
    };

    // Save customized menu
    $('#menuForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'controller/bookings.php',
            type: 'POST',
            data: {
                action: 'saveMenu',
                booking_id: $('#bookingId').val(),
                menu_items: $('#menuItems').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#customizeMenuModal').modal('hide');
                    toastr.success('Menu saved successfully.');
                } else {
                    toastr.error(response.message || 'Failed to save menu.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('An error occurred while saving the menu.');
            }
        });
    });
});
</script>

<?php include('include/footer.php'); ?>
