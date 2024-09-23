<?php
include('../include/db_connect.php'); 
include('../include/head.php'); 
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<?php include('../include/nav.php'); ?>

<link rel="stylesheet" href="css/order.css">
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Orders</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="order-list">
                <!-- Orders will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for messaging -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel" style="color: black;">Messages for Order: <span id="modal-order-number"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Messages List Container -->
                <div id="message-list" class="message-list mb-3" style="max-height: 300px; overflow-y: auto;">
                    <!-- Messages will be dynamically inserted here -->
                </div>
                
                <!-- Message Input Form -->
                <form id="message-form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="message">New Message</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Type your message here..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Attach Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" accept="image/*">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('../include/foot.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to fetch orders from the server
    function fetchOrders() {
        $.ajax({
            url: '../controller/orders.php?action=getUserOrders', // Endpoint to fetch orders
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderOrders(response.orders);
                }
            },
            error: function(error) {
                console.error('Error fetching orders:', error);
            }
        });
    }

    // Function to render orders in the table
    function renderOrders(orders) {
        const orderList = $('#order-list');
        orderList.empty();

        if (Array.isArray(orders)) {
            orders.forEach(order => {
                const orderItem = `
                    <tr>
                        <td data-label="Order Number">${order.order_number ? order.order_number : 'N/A'}</td>
                        <td data-label="Date">${order.order_date ? order.order_date : 'N/A'}</td>
                        <td data-label="Items">${order.item_name ? order.item_name : 'N/A'}</td>
                        <td data-label="Total Amount">₱${order.total_amount ? order.total_amount : '0.00'}</td>
                        <td data-label="Status">${order.order_status ? order.order_status : 'Pending'}</td>
                        <td data-label="Action">
                            <button class="btn btn-info btn-sm" onclick="openMessageModal('${order.order_number}')">Messages</button>
                        </td>
                    </tr>
                `;
                orderList.append(orderItem);
            });
        } else {
            console.error("Orders data is not an array:", orders);
        }
    }

    // Function to open the message modal for a specific order
    function openMessageModal(orderNumber) {
        $('#modal-order-number').text(orderNumber);
        $('#messageModal').modal('show');
        fetchMessages(orderNumber);
    }

    // Fetch messages for a specific order
    function fetchMessages(orderNumber) {
        $.ajax({
            url: '../controller/messages.php?action=fetchMessages',
            method: 'GET',
            data: { order_number: orderNumber },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    renderMessages(result.messages);
                } else {
                    console.error(result.message);
                }
            },
            error: function(error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Function to render messages
    function renderMessages(messages) {
        const messageList = $('#message-list');
        messageList.empty();

        if (Array.isArray(messages)) {
            messages.forEach(message => {
                const bubbleClass = message.sender === 'User' ? 'customer' : 'admin'; // Check if sender is 'User' or 'Admin'
                const messageItem = `
                    <div class="chat-bubble ${bubbleClass}">
                        <p>${message.text}</p>
                        <div class="timestamp">${message.timestamp}</div>
                    </div>
                `;
                messageList.append(messageItem);
            });
            // Scroll to the bottom of the chat
            messageList.scrollTop(messageList.prop("scrollHeight"));
        }
    }


    // Handling form submission
    $('#message-form').on('submit', function (e) {
        e.preventDefault();
        const message = $('#message').val();
        const image = $('#image')[0].files[0];
        const orderNumber = $('#modal-order-number').text();
        const formData = new FormData();
        formData.append('order_number', orderNumber);
        formData.append('message', message);
        if (image) {
            formData.append('image', image);
        }

        if (message.trim()) {
            sendMessage(formData);
            $('#message').val('');
            $('#image').val('');
        }
    });


    // Display selected file name
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Initial rendering of orders
    $(document).ready(function() {
        fetchOrders();
    });
</script>
</body>
</html>
