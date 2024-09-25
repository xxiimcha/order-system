<?php
include('../../include/db_connect.php');

// Get the selected interval from the URL parameter
$interval = isset($_GET['interval']) ? $_GET['interval'] : 'monthly';

// Fetch sales data based on selected interval
switch ($interval) {
    case 'daily':
        $sql_sales_data = "SELECT DATE(order_date) as period, SUM(total_amount) as total_sales 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY period 
                           ORDER BY period DESC 
                           LIMIT 7"; // Last 7 days
        break;
    
    case 'weekly':
        $sql_sales_data = "SELECT CONCAT(YEAR(order_date), ' W', WEEK(order_date)) as period, SUM(total_amount) as total_sales 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY YEAR(order_date), WEEK(order_date) 
                           ORDER BY YEAR(order_date) DESC, WEEK(order_date) DESC 
                           LIMIT 8"; // Last 8 weeks
        break;
    
    case 'monthly':
    default:
        $sql_sales_data = "SELECT DATE_FORMAT(order_date, '%Y-%m') as period, SUM(total_amount) as total_sales 
                           FROM orders 
                           WHERE order_status = 'Completed' 
                           GROUP BY period 
                           ORDER BY period DESC 
                           LIMIT 6"; // Last 6 months
        break;
}

$result_sales_data = $conn->query($sql_sales_data);

$sales_labels = [];
$sales_data = [];

if ($result_sales_data->num_rows > 0) {
    while ($row = $result_sales_data->fetch_assoc()) {
        $sales_labels[] = $row['period'];
        $sales_data[] = $row['total_sales'];
    }
}

// Return the data as JSON
echo json_encode(['labels' => array_reverse($sales_labels), 'sales' => array_reverse($sales_data)]);

$conn->close();
?>
