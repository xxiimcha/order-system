<?php include('include/header.php');?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            
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
                                <th>Amount</th>
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
                                            <td>{$row['total_amount']}</td>
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
// Ensure the element exists before trying to use it
document.addEventListener('DOMContentLoaded', (event) => {
    const salesChartCanvas = document.getElementById('salesChart');
    
    if (salesChartCanvas) {
        const salesChartCtx = salesChartCanvas.getContext('2d');
        const salesChart = new Chart(salesChartCtx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Sales in USD',
                    data: [500, 1000, 750, 1250, 950, 1500],
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
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
