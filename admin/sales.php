<?php 
include('../include/db_connect.php');
include('include/header.php'); 

// Default interval is monthly
$interval = isset($_GET['interval']) ? $_GET['interval'] : 'monthly';

// Fetch sales data based on selected interval
switch ($interval) {
    case 'daily':
        $sql_sales_data = "SELECT DATE(order_date) as period, SUM(total_amount) as total_sales, COUNT(order_id) as total_orders 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY period 
                           ORDER BY period ASC 
                           LIMIT 7"; // Last 7 days
        break;
    
    case 'weekly':
        $sql_sales_data = "SELECT CONCAT(YEAR(order_date), ' W', WEEK(order_date)) as period, SUM(total_amount) as total_sales, COUNT(order_id) as total_orders 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY YEAR(order_date), WEEK(order_date) 
                           ORDER BY YEAR(order_date) DESC, WEEK(order_date) DESC 
                           LIMIT 8"; // Last 8 weeks
        break;
    
    case 'monthly':
    default:
        $sql_sales_data = "SELECT DATE_FORMAT(order_date, '%Y-%m') as period, SUM(total_amount) as total_sales, COUNT(order_id) as total_orders 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY period 
                           ORDER BY period DESC 
                           LIMIT 6"; // Last 6 months
        break;
}

$result_sales_data = $conn->query($sql_sales_data);

$sales_data = [];
$sales_labels = [];
$orders_data = [];

if ($result_sales_data->num_rows > 0) {
    while ($row = $result_sales_data->fetch_assoc()) {
        $sales_labels[] = $row['period'];
        $sales_data[] = $row['total_sales'];
        $orders_data[] = $row['total_orders'];
    }
}

// Close the database connection
$conn->close();
?>

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Sales Projection</h1>
            
            <!-- Interval Selection Dropdown -->
            <div class="mb-4">
                <label for="intervalSelect" class="form-label">Select Interval:</label>
                <select id="intervalSelect" class="form-control" onchange="changeInterval()">
                    <option value="daily" <?php echo $interval == 'daily' ? 'selected' : ''; ?>>Daily</option>
                    <option value="weekly" <?php echo $interval == 'weekly' ? 'selected' : ''; ?>>Weekly</option>
                    <option value="monthly" <?php echo $interval == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                </select>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Completed Sales Projection (<?php echo ucfirst($interval); ?>)
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="100%" height="40"></canvas>
                </div>
            </div>

            <h1 class="mt-4">Orders Projection</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Total Completed Orders (<?php echo ucfirst($interval); ?>)
                </div>
                <div class="card-body">
                    <canvas id="ordersChart" width="100%" height="40"></canvas>
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

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Get sales data from PHP variables
const salesLabels = <?php echo json_encode($sales_labels); ?>;
const salesData = <?php echo json_encode($sales_data); ?>;
const ordersData = <?php echo json_encode($orders_data); ?>;

// Create the sales chart
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'bar', 
    data: {
        labels: salesLabels,
        datasets: [{
            label: 'Total Sales (₱)',
            data: salesData,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Sales Amount (₱)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: '<?php echo ucfirst($interval); ?>'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(tooltipItem) {
                        return '₱' + tooltipItem.parsed.y.toLocaleString(); // Format currency with comma separators
                    }
                }
            }
        }
    }
});

// Create the orders chart
const ctx2 = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: salesLabels,
        datasets: [{
            label: 'Total Completed Orders',
            data: ordersData,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: true,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Orders'
                }
            },
            x: {
                title: {
                    display: true,
                    text: '<?php echo ucfirst($interval); ?>'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                enabled: true,
            }
        }
    }
});

// Function to change the interval and reload the page
function changeInterval() {
    const selectedInterval = document.getElementById('intervalSelect').value;
    window.location.href = '?interval=' + selectedInterval;
}
</script>

<?php include('include/footer.php'); ?>
