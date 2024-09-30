<?php 
include('../include/db_connect.php');
include('include/header.php'); 
?>

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Orders</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Order Management</li>
            </ol>

            <!-- Order List Table -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-boxes me-1"></i>
                    Order List
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            <?php
                            // Retrieve all orders from the database
                            $sql = "SELECT orders.*, users.username AS customer_name, users.email AS customer_email 
                                    FROM orders 
                                    JOIN users ON orders.user_id = users.id
                                    ORDER BY orders.order_date DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Determine badge color based on the status
                                    $badgeClass = '';
                                    switch ($row['order_status']) {
                                        case 'Pending':
                                            $badgeClass = 'badge bg-warning text-dark';
                                            break;
                                        case 'Processing':
                                            $badgeClass = 'badge bg-primary';
                                            break;
                                        case 'Shipped':
                                            $badgeClass = 'badge bg-info text-dark';
                                            break;
                                        case 'Delivered':
                                            $badgeClass = 'badge bg-success';
                                            break;
                                        case 'Completed':
                                            $badgeClass = 'badge bg-dark';
                                            break;
                                        default:
                                            $badgeClass = 'badge bg-secondary';
                                            break;
                                    }

                                    $statusHtml = "<span class='{$badgeClass}'>{$row['order_status']}</span>";

                                    echo "<tr>
                                        <td>{$row['order_number']}</td>
                                        <td>{$row['order_date']}</td>
                                        <td>{$row['customer_name']}</td>
                                        <td>{$row['customer_email']}</td>
                                        <td>{$row['item_name']} (x{$row['quantity']})</td>
                                        <td>₱{$row['total_amount']}</td>
                                        <td>{$statusHtml}</td>
                                        <td>
                                            <button onclick='openChatModal(\"{$row['user_id']}\", \"{$row['customer_name']}\", \"{$row['order_number']}\")' class='btn btn-sm btn-primary'>Message</button>
                                            <button onclick='viewOrderDetails({$row['order_id']})' class='btn btn-sm btn-info'>View</button>                                            
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No orders found.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
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
<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Order details will be loaded here -->
                <div id="orderDetails"></div>
                
                <div class="form-group mt-3">
                    <label for="orderStatusSelect">Update Order Status:</label>
                    <select id="orderStatusSelect" class="form-control">
                        <option value='Pending'>Pending</option>
                        <option value='Processing'>Processing</option>
                        <option value='Shipped'>Shipped</option>
                        <option value='Delivered'>Delivered</option>
                        <option value='Completed'>Completed</option>
                    </select>
                </div>
                <button onclick="updateOrderStatusInModal()" class="btn btn-success mt-3">Update Status</button>
            </div>
        </div>
    </div>
</div>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Chat with Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <div class="chat-box" style="height: 300px; overflow-y: scroll; padding: 10px; margin-bottom: 10px; border-radius: 8px; background-color: #fff; border: 1px solid #ddd;">
                    <!-- Chat messages will be appended here -->
                    <div id="chatMessages" style="display: flex; flex-direction: column; gap: 8px;"></div>
                </div>
                <div class="input-group">
                    <input type="text" id="chatMessageInput" class="form-control" placeholder="Type your message here..." style="border-radius: 20px;">
                    <button id="sendMessageButton" class="btn btn-primary" onclick="sendMessage()" style="border-radius: 50%;">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Chat message bubble styles */
.chat-box {
    height: 300px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
    border-radius: 10px;
}

.chat-bubble {
    padding: 10px 15px;
    border-radius: 20px;
    margin-bottom: 10px;
    max-width: 70%;
    display: inline-block;
    font-size: 14px;
    position: relative;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
}

.chat-bubble.admin {
    background-color: #e0f7fa;
    align-self: flex-end;
    color: #007b7f;
    margin-left: auto;
    border-top-right-radius: 0;
}

.chat-bubble.customer {
    background-color: #e8eaf6;
    align-self: flex-start;
    color: #3949ab;
    margin-right: auto;
    border-top-left-radius: 0;
}

.chat-bubble::after {
    content: '';
    position: absolute;
    bottom: -5px;
    width: 0;
    height: 0;
    border-style: solid;
}

.chat-bubble.admin::after {
    border-width: 0 10px 10px 0;
    border-color: transparent #e0f7fa transparent transparent;
    right: 0;
}

.chat-bubble.customer::after {
    border-width: 10px 10px 0 0;
    border-color: #e8eaf6 transparent transparent transparent;
    left: 0;
}

.timestamp {
    font-size: 11px;
    color: #777;
    text-align: right;
    margin-top: 5px;
}
</style>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

let selectedOrderId = null; // Store the selected order ID

function viewOrderDetails(orderId) {
    selectedOrderId = orderId; // Store the order ID
    $('#viewOrderModal').modal('show'); // Show the modal

    // Fetch order details from the server
    $.ajax({
        url: 'controller/orders.php?action=getOrderDetails',
        type: 'GET',
        data: { order_id: orderId },
        dataType: 'json',
        success: function(response) {
            console.log(response); // Check the response in the browser console
            if (response.success) {
                // Populate the modal with order details
                const order = response.order;

                $('#orderDetails').html(`
                    <p><strong>Order Number:</strong> ${order.order_number}</p>
                    <p><strong>Order Date:</strong> ${order.order_date}</p>
                    <p><strong>Customer Name:</strong> ${order.customer_name}</p>
                    <p><strong>Customer Email:</strong> ${order.customer_email}</p>
                    <p><strong>Items:</strong> ${order.item_name} (x${order.quantity})</p>
                    <p><strong>Total Amount:</strong> ₱${order.total_amount}</p>
                    <p><strong>Order Type:</strong> ${order.order_type}</p>
                    <p><strong>Payment Mode:</strong> ${order.payment_mode}</p>
                    <p><strong>Delivery Address:</strong> ${order.delivery_address || 'N/A'}</p>
                    <p><strong>Order Status:</strong> ${order.order_status}</p>
                `);

                // Set the current order status in the select input
                $('#orderStatusSelect').val(order.order_status);
            } else {
                toastr.error('Error fetching order details');
            }
        },
        error: function(error) {
            console.error('Error fetching order details:', error);
        }
    });
}


function updateOrderStatusInModal() {
    const newStatus = $('#orderStatusSelect').val(); // Get the new status from the select input

    // Send an AJAX request to update the order status
    $.ajax({
        url: 'controller/orders.php?action=updateOrderStatus',
        type: 'POST',
        dataType: 'json',
        data: {
            order_id: selectedOrderId,
            status: newStatus
        },
        success: function(response) {
            if (response.success) {
                toastr.success('Order status updated successfully.');

                // Update the status badge in the main table (refresh or change the row display)
                $(`#order-list tr`).each(function() {
                    if ($(this).find('td:first').text() == response.order_number) {
                        $(this).find('td:nth-child(7)').html(`<span class='badge bg-${newStatus == 'Completed' ? 'success' : 'info'}'>${newStatus}</span>`);
                    }
                });

                $('#viewOrderModal').modal('hide'); // Hide the modal
            } else {
                toastr.error('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating order status:', error);
            toastr.error('Error: ' + xhr.responseText);
        }
    });
}

// Toastr options
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

let currentUserId = null;
let currentOrderNumber = null;

function openChatModal(userId, customerName, orderNumber) {
    currentUserId = userId;
    currentOrderNumber = orderNumber;
    $('#chatModalLabel').text(`Chat with ${customerName} (Order: ${orderNumber})`);
    $('#chatModal').modal('show');
    
    // Clear the chat messages to avoid showing messages from unrelated orders
    $('#chatMessages').empty();
    
    fetchChatMessages(); // Fetch existing chat messages for the user

    // Fetch order status to check if it's completed
    $.ajax({
        url: 'controller/orders.php?action=getOrderStatus',
        type: 'GET',
        data: { order_id: orderNumber },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                if (response.status === 'Completed') {
                    // Disable the input and send button
                    $('#chatMessageInput').prop('disabled', true);
                    $('#chatMessageInput').attr('placeholder', 'Order is completed. You cannot send messages.');
                    $('#sendMessageButton').prop('disabled', true);
                } else {
                    // Enable the input and send button
                    $('#chatMessageInput').prop('disabled', false);
                    $('#chatMessageInput').attr('placeholder', 'Type your message here...');
                    $('#sendMessageButton').prop('disabled', false);
                }
            }
        },
        error: function(error) {
            console.error('Error fetching order status:', error);
        }
    });
}

// Function to fetch chat messages
function fetchChatMessages() {
    $.ajax({
        url: 'controller/messages.php?action=getMessages',
        type: 'GET',
        data: { user_id: currentUserId, order_number: currentOrderNumber },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const chatMessages = response.messages;
                const chatBox = $('#chatMessages');
                chatBox.empty();
                chatMessages.forEach(msg => {
                    const bubbleClass = msg.sender === 'admin' ? 'admin' : 'customer';
                    const messageHTML = `
                        <div class="chat-bubble ${bubbleClass}">
                            <span>${msg.message}</span>
                            <div class="timestamp">${msg.timestamp}</div>
                        </div>`;
                    chatBox.append(messageHTML);
                });
                $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight); // Scroll to bottom
            } else {
                toastr.error('No messages found or unable to fetch messages');
            }
        },
        error: function(error) {
            console.error('Error fetching messages:', error);
        }
    });
}

// Function to update order status
function updateOrderStatus(orderId, status) {
    console.log(`Updating order ID: ${orderId} to status: ${status}`); // Add console log here

    $.ajax({
        url: 'controller/orders.php?action=updateOrderStatus', // Ensure this URL points to your PHP controller
        type: 'POST',
        dataType: 'json',
        data: {
            order_id: orderId,
            status: status
        },
        success: function(response) {
            if (response.success) {
                toastr.success('Order status updated successfully.');
                if (status === 'Completed') {
                    // Change status display to badge
                    $(`select[data-order-id='${orderId}']`).parent().html("<span class='badge bg-success'>Completed</span>");
                }
            } else {
                toastr.error('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating order status:', error); // Additional console log
            toastr.error('Error: ' + xhr.responseText);
        }
    });
}

function sendMessage() {
    const message = $('#chatMessageInput').val(); // Get message from the input field

    if (message.trim() !== '') {
        $.ajax({
            url: 'controller/messages.php?action=sendMessage', // Ensure the URL is correct
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: {
                order_number: currentOrderNumber,
                user_id: currentUserId,
                message: message,
                sender: 'admin' // Specify that the message is sent by the admin
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Message sent successfully.');
                    $('#chatMessageInput').val(''); // Clear the input field
                    fetchChatMessages(); // Refresh the chat messages
                } else {
                    toastr.error('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error: ' + xhr.responseText);
            }
        });
    }
}
</script>

<?php include('include/footer.php'); ?>
