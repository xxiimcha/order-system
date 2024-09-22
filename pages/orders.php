<?php
include('../include/db_connect.php'); 
include('../include/head.php'); 
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<?php include('../include/nav.php'); ?>
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
                </tr>
            </thead>
            <tbody id="order-list">
                <!-- Orders will be dynamically inserted here -->
            </tbody>
        </table>
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
                    </tr>
                `;
                orderList.append(orderItem);
            });
        } else {
            console.error("Orders data is not an array:", orders);
        }
    }

    // Function to set CSS class based on order status
    function getStatusClass(status) {
        switch (status.toLowerCase()) {
            case 'pending':
                return 'text-warning font-weight-bold';
            case 'completed':
                return 'text-success font-weight-bold';
            case 'canceled':
                return 'text-danger font-weight-bold';
            case 'in progress':
                return 'text-info font-weight-bold';
            default:
                return '';
        }
    }

    // Initial rendering of orders
    $(document).ready(function() {
        fetchOrders();
    });
</script>

<style>
h2 {
    color: #343a40;
}

.table-responsive {
    border-radius: 10px;
    overflow: hidden;
}

.table {
    background-color: #ffffff; /* Set the table's overall background color */
}

.table thead {
    background-color: #343a40;
    color: #fff;
}

.table thead th {
    border: none;
    padding: 15px;
    font-size: 16px;
}

.table tbody tr {
    transition: all 0.3s;
    background-color: #f8f9fa; /* Set the default background color for rows */
}

.table tbody tr:nth-child(even) {
    background-color: #e9ecef; /* Alternate background color for even rows */
}

.table tbody tr:hover {
    background-color: #dee2e6; /* Background color when hovered */
}

.table tbody td {
    padding: 15px;
    vertical-align: middle;
    color: #333;
}

/* Mobile responsive styling */
@media (max-width: 767.98px) {
    .table thead {
        display: none;
    }

    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }

    .table tr {
        margin-bottom: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background: #fff;
    }

    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        background-color: #f8f9fa; /* Ensure background color on mobile */
    }

    .table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
        color: #555;
    }
}

</style>
</body>
</html>
