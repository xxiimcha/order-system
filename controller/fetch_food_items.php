<?php
include('../include/db_connect.php');

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Define the SQL query based on the category
    if ($category == 'all') {
        $sql = "SELECT * FROM products";
    } else {
        // Sanitize the category input to prevent SQL injection
        $category = $conn->real_escape_string($category);
        $sql = "SELECT * FROM products WHERE category = '$category'";
    }

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query execution was successful
    if ($result) {
        // Check if there are any results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="food-item" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '">';
                echo '<div class="image-container">';
                echo '<img src="../uploads/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '</div>';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
                echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
                echo '<p>Price: ₱' . $row['price'] . '</p>';
                
                // Check for sizes and display them
                if (!empty($row['sizes'])) {
                    echo '<div class="size-label">Choose Size:</div>';
                    echo '<div class="size-buttons">';
                    $sizes = json_decode($row['sizes'], true);
                    if ($sizes) {
                        foreach ($sizes as $size) {
                            echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
                        }
                    }
                    echo '</div>';
                }

                // Quantity input for adding to cart
                echo '<div class="quantity-container">';
                echo '<label for="quantity-' . $row['id'] . '">Quantity:</label>';
                echo '<input type="number" id="quantity-' . $row['id'] . '" min="1" value="1" class="quantity-input">';
                echo '</div>';

                echo '<div class="action-buttons">';
                echo '<a href="#" class="order-button" onclick="openOrderModal(\'' . $row['name'] . '\')">Order Now</a>';
                echo '<a href="#" class="cart-button" onclick="addToCart(' . $row['id'] . ')">Add to Cart</a>'; // Added onclick function with quantity
                echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No items found.";
        }
    } else {
        echo "Failed to execute query: " . $conn->error;
    }
} else {
    echo "Category not provided.";
}

$conn->close();
?>
