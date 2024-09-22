<?php
include('../../include/db_connect.php');

// Add product function
function addProduct($conn) {
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $stock = $_POST['product_stock'];
    $sizes = isset($_POST['product_size']) ? json_encode($_POST['product_size']) : null;
    $flavors = isset($_POST['product_flavors']) ? $_POST['product_flavors'] : null;
    $course_type = isset($_POST['course_type']) ? $_POST['course_type'] : null;
    $portions = isset($_POST['product_portions']) ? $_POST['product_portions'] : null;

    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image = $_FILES['product_image']['name'];
        $target_dir = "../../uploads/";  // Correct path to the uploads directory outside the admin folder
        $target_file = $target_dir . basename($image);

        // Ensure the directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);  // Create the directory if it doesn't exist
        }

        // Check if the file is a valid uploaded file and move it
        if (is_uploaded_file($_FILES['product_image']['tmp_name'])) {
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
                // Insert product into the database
                $sql = "INSERT INTO products (name, category, description, price, stock, image, sizes, flavors, course_type, portions) 
                        VALUES ('$name', '$category', '$description', '$price', '$stock', '$image', '$sizes', '$flavors', '$course_type', '$portions')";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => $conn->error]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving uploaded file.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid uploaded file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading image.']);
    }
}

// Update product function
function updateProduct($conn) {
    $product_id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['product_category'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $stock = $_POST['product_stock'];
    $sizes = isset($_POST['product_size']) ? json_encode($_POST['product_size']) : null;
    $flavors = isset($_POST['product_flavors']) ? $_POST['product_flavors'] : null;
    $course_type = isset($_POST['course_type']) ? $_POST['course_type'] : null;
    $portions = isset($_POST['product_portions']) ? $_POST['product_portions'] : null;

    // Check if there's a new image uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image = $_FILES['product_image']['name'];
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($image);

        if (is_uploaded_file($_FILES['product_image']['tmp_name'])) {
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
                // Update product with the new image
                $sql = "UPDATE products SET 
                            name='$name', 
                            category='$category', 
                            description='$description', 
                            price='$price', 
                            stock='$stock',
                            image='$image',
                            sizes='$sizes',
                            flavors='$flavors',
                            course_type='$course_type',
                            portions='$portions'
                        WHERE id=$product_id";
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving uploaded file.']);
                return;
            }
        }
    } else {
        // Update without changing the image
        $sql = "UPDATE products SET 
                    name='$name', 
                    category='$category', 
                    description='$description', 
                    price='$price', 
                    stock='$stock',
                    sizes='$sizes',
                    flavors='$flavors',
                    course_type='$course_type',
                    portions='$portions'
                WHERE id=$product_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}

// Delete product function
function deleteProduct($conn) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM products WHERE id=$product_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}

// Handle different actions (add, update, delete)
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        addProduct($conn);
        break;

    case 'update':
        updateProduct($conn);
        break;

    case 'delete':
        deleteProduct($conn);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

$conn->close();
