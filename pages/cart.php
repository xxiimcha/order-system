<?php
include('../include/db_connect.php'); 
include('../include/head.php'); 

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<p>You need to be logged in to view your cart.</p>";
    exit;
}

$user_id = $_SESSION['id']; // Assuming user_id is stored in session when logged in
?>

<?php include('../include/nav.php'); ?>

<link rel="stylesheet" href="css/cart.css">
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Cart</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-list">
                <!-- Cart items will be dynamically inserted here -->
            </tbody>
        </table>
        <div class="container mt-3">
    <button class="btn btn-success" id="checkout-btn">Checkout</button>
</div>
    </div>
</div>

<?php include('../include/foot.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to fetch cart items from the server
    function fetchCartItems() {
        $.ajax({
            url: '../controller/cart.php?action=getUserCartItems', // Endpoint to fetch cart items
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderCartItems(response.cartItems);
                }
            },
            error: function(error) {
                console.error('Error fetching cart items:', error);
            }
        });
    }

    // Function to render cart items in the table
    function renderCartItems(cartItems) {
        const cartList = $('#cart-list');
        cartList.empty();

        if (Array.isArray(cartItems)) {
            cartItems.forEach(item => {
                const cartItem = `
                    <tr>
                        <td data-label="Product Name">${item.product_name ? item.product_name : 'N/A'}</td>
                        <td data-label="Price">₱${item.price ? item.price : '0.00'}</td>
                        <td data-label="Quantity">${item.quantity ? item.quantity : '1'}</td>
                        <td data-label="Total Amount">₱${item.total ? item.total : '0.00'}</td>
                        <td data-label="Action">
                            <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remove</button>
                        </td>
                    </tr>
                `;
                cartList.append(cartItem);
            });
        } else {
            console.error("Cart items data is not an array:", cartItems);
        }
    }

    // Function to remove an item from the cart
    function removeFromCart(cartItemId) {
        $.ajax({
            url: '../controller/cart.php?action=removeCartItem',
            type: 'POST',
            data: { id: cartItemId },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    fetchCartItems(); // Refresh the cart items
                } else {
                    alert('Error removing item: ' + data.message);
                }
            },
            error: function () {
                console.error('Failed to remove item from cart.');
            }
        });
    }

    // Initial rendering of cart items
    $(document).ready(function() {
        fetchCartItems();
    });

    $('#checkout-btn').on('click', function() {
        $.ajax({
            url: '../controller/cart.php?action=checkout',
            type: 'POST',
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('Checkout completed successfully!');
                    fetchCartItems(); // Refresh cart items
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function() {
                console.error('Failed to complete checkout.');
            }
        });
    });
</script>
</body>
</html>
