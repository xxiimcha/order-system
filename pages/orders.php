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
                <h5 class="modal-title" id="messageModalLabel" style="color: black;">
                    Chat with <span id="modal-username"></span> (Order: <span id="modal-order-number"></span>)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Messages List Container -->
                <div id="message-list" class="message-list" style="max-height: 300px; overflow-y: auto;">
                    <!-- Messages will be dynamically inserted here -->
                </div>
                
                <!-- Message Input Form -->
                <form id="message-form" enctype="multipart/form-data" style="margin-top: 15px;">
                    <div class="form-group">
                        <label for="message">New Message</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Type your message here..."></textarea>
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

    // Fetch and render messages for a specific order number
    function fetchMessages(orderNumber) {
        $.ajax({
            url: '../controller/messages.php?action=fetchMessages',
            type: 'GET',
            data: { order_number: orderNumber },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    renderMessages(data.messages);
                } else {
                    console.error('Error fetching messages:', data.message);
                }
            },
            error: function () {
                console.error('Failed to load messages.');
            }
        });
    }

    // Render messages in the modal
    function renderMessages(messages) {
        const messageList = $('#message-list');
        messageList.empty(); // Clear any existing messages

        messages.forEach(message => {
            const senderClass = message.sender === 'User' ? 'chat-bubble customer' : 'chat-bubble admin';
            const messageBubble = `
                <div class="${senderClass}">
                    <p>${message.text}</p>
                    <div class="timestamp">${message.timestamp}</div>
                </div>
            `;
            messageList.append(messageBubble);
        });

        // Scroll to the bottom of the chat box to show the latest message
        messageList.scrollTop(messageList[0].scrollHeight);
    }

    // Handle form submission for sending a new message
    $('#message-form').on('submit', function (e) {
        e.preventDefault();
        const messageText = $('#message').val().trim();

        if (messageText) {
            const formData = new FormData();
            formData.append('order_number', $('#modal-order-number').text());
            formData.append('message', messageText);

            $.ajax({
                url: '../controller/messages.php?action=sendMessage',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        fetchMessages($('#modal-order-number').text()); // Refresh the messages
                        $('#message').val(''); // Clear the input field
                    } else {
                        alert('Error sending message: ' + data.message);
                    }
                },
                error: function () {
                    console.error('Failed to send message.');
                }
            });
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
