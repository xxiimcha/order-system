<?php 
include('../include/db_connect.php');
include('../include/head.php');
include('../include/nav.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<link rel="stylesheet" href="css/messages.css">
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Messages</h2>
            </div>
            <div class="card-body conversation-container">
                <div id="message-list" class="message-list">
                    <!-- Messages will be dynamically inserted here -->
                </div>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch messages from the server
        function fetchMessages(orderNumber) {
            $.ajax({
                url: '../controller/messages.php?action=fetchMessages',
                type: 'GET',
                data: { order_number: orderNumber },
                success: function (data) {
                    const response = JSON.parse(data);
                    if (response.status === 'success') {
                        renderMessages(response.messages);
                    } else {
                        console.error(response.message);
                    }
                },
                error: function () {
                    console.error('Failed to load messages.');
                }
            });
        }

        // Function to render messages in the conversation view
        function renderMessages(messages) {
            const messageList = $('#message-list');
            messageList.empty();
            messages.forEach(message => {
                const alignmentClass = message.sender === 'User' ? 'sent' : 'received';
                const messageItem = `
                    <div class="message-item ${alignmentClass}">
                        <p>${message.text}</p>
                        ${message.image ? `<img src="${message.image}" alt="Attached Image">` : ''}
                        <small>${message.timestamp}</small>
                    </div>
                `;
                messageList.append(messageItem);
            });
            // Scroll to the bottom of the message list
            messageList.scrollTop(messageList[0].scrollHeight);
        }

        // Send a message to the server
        function sendMessage(formData) {
            $.ajax({
                url: '../controller/messages.php?action=sendMessage',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        fetchMessages(formData.get('order_number')); // Reload messages after sending
                    } else {
                        alert(result.message);
                    }
                },
                error: function () {
                    console.error('Failed to send message.');
                }
            });
        }

        // Initial rendering of messages
        $(document).ready(function () {
            const orderNumber = 'YOUR_ORDER_NUMBER'; // Replace with the actual order number
            fetchMessages(orderNumber);
        });

        // Handling form submission
        $('#message-form').on('submit', function (e) {
            e.preventDefault();
            const message = $('#message').val();
            const image = $('#image')[0].files[0];
            const orderNumber = 'YOUR_ORDER_NUMBER'; // Replace with the actual order number
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
        // Fetch the list of not completed orders for the logged-in user
        function fetchOrderList() {
            $.ajax({
                url: '../controller/messages.php?action=fetchOrderList',
                type: 'GET',
                success: function (data) {
                    const response = JSON.parse(data);
                    if (response.status === 'success') {
                        renderOrderList(response.orders);
                    } else {
                        console.error(response.message);
                    }
                },
                error: function () {
                    console.error('Failed to load orders.');
                }
            });
        }

        // Render the list of orders in a dropdown or list
        function renderOrderList(orders) {
            const orderList = $('#order-list');
            orderList.empty();
            orders.forEach(order => {
                const orderItem = `<option value="${order.order_number}">${order.order_number} - ${order.status}</option>`;
                orderList.append(orderItem);
            });
        }

        // Call fetchOrderList when the page loads
        $(document).ready(function () {
            fetchOrderList();
        });

    </script>
</body>
</html>
