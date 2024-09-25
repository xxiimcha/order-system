<?php include('include/header.php');?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            
            <!-- Interval Selection Dropdown for Sales Chart -->
            <div class="mb-4">
                <label for="intervalSelect" class="form-label">Select Interval:</label>
                <select id="intervalSelect" class="form-control" onchange="loadSalesData()">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                </select>
            </div>
            
            <!-- Sales Chart -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Sales Chart
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="100%" height="40"></canvas>
                </div>
            </div>
            
            <!-- Pending Orders -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Pending Orders
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pendingOrdersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Amount (₱)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../include/db_connect.php'); // Adjust this path based on your project structure

                            // Fetch pending orders
                            $query = "SELECT o.order_id, u.username AS customer_name, o.order_date, o.order_status, o.total_amount 
                                      FROM orders o 
                                      LEFT JOIN users u ON o.user_id = u.id 
                                      WHERE o.order_status = 'Pending'";

                            $result = mysqli_query($conn, $query);

                            // Check if any pending orders are found
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['order_id']}</td>
                                            <td>{$row['customer_name']}</td>
                                            <td>{$row['order_date']}</td>
                                            <td>{$row['order_status']}</td>
                                            <td>₱" . number_format($row['total_amount'], 2) . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No pending orders found</td></tr>";
                            }
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
<?php include('include/footer.php');?>

<script>
    // Function to load sales data based on interval using $.ajax
    function loadSalesData() {
        const interval = $('#intervalSelect').val(); // Get the selected interval

        $.ajax({
            url: 'controller/sales_data.php', // The URL to your PHP script
            type: 'GET',
            data: { interval: interval }, // Pass the interval as a parameter
            dataType: 'json',
            success: function(response) {
                console.log('Sales data response:', response); // Debug: Log response

                // Check if data is valid
                if (!response || !response.labels || !response.sales || response.labels.length === 0 || response.sales.length === 0) {
                    console.error('No data available or invalid data structure.');
                    alert('No data available for the selected interval.');
                    return;
                }

                if (window.salesChart) {
                    window.salesChart.destroy(); // Destroy the existing chart if it exists
                }

                const ctx = document.getElementById('salesChart').getContext('2d');
                window.salesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Total Sales (₱)',
                            data: response.sales,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            datalabels: {
                                color: 'black', // Color of the data labels
                                display: true, // Show data labels
                                align: 'top',
                                formatter: (value) => '₱' + value.toLocaleString(), // Format values as currency
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString(); // Format currency
                                    }
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Activate the data labels plugin
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sales data:', error); // Log the error
            }
        });
    }

    // Load initial sales data for the default 'monthly' interval
    $(document).ready(function() {
        loadSalesData();
    });
</script>
