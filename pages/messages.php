<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .message-list {
            max-height: 300px;
            overflow-y: auto;
        }
        .message-item {
            margin-bottom: 10px;
        }
        .message-item img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
        .custom-file-input ~ .custom-file-label::after {
            content: "Browse";
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Messages</h2>
            </div>
            <div class="card-body">
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
        // Placeholder function to simulate fetching messages
        function fetchMessages() {
            // Replace this with actual logic to fetch messages
            return [
                { sender: 'La Farina', text: 'Welcome to our service!', timestamp: '2024-07-14 12:34:56' },
            ];
        }

        // Function to render messages
        function renderMessages(messages) {
            const messageList = $('#message-list');
            messageList.empty();
            messages.forEach(message => {
                const messageItem = `
                    <div class="message-item">
                        <div class="alert alert-secondary" role="alert">
                            <strong>${message.sender}</strong> <small class="text-muted">${message.timestamp}</small>
                            <p>${message.text}</p>
                            ${message.image ? `<img src="${message.image}" alt="Attached Image">` : ''}
                        </div>
                    </div>
                `;
                messageList.append(messageItem);
            });
        }

        // Initial rendering of messages
        $(document).ready(function() {
            const messages = fetchMessages();
            renderMessages(messages);
        });

        // Placeholder function to simulate sending a message
        function sendMessage(formData) {
            // Replace this with actual logic to send a message
            console.log('Message sent:', formData);
        }

        // Handling form submission
        $('#message-form').on('submit', function(e) {
            e.preventDefault();
            const message = $('#message').val();
            const image = $('#image')[0].files[0];
            const formData = new FormData();
            formData.append('sender', 'User');
            formData.append('message', message);
            formData.append('image', image);

            if (message.trim()) {
                sendMessage(formData);
                $('#message').val('');
                $('#image').val('');
                const newMessage = {
                    sender: 'User',
                    text: message,
                    timestamp: new Date().toISOString(),
                    image: image ? URL.createObjectURL(image) : null
                };
                const messages = fetchMessages().concat(newMessage);
                renderMessages(messages);
            }
        });

        // Display selected file name
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
        });
    </script>
</body>
</html>
