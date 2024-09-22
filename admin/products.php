<?php 
include('../include/db_connect.php');
include('include/header.php'); 
?>

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Products</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Products</li>
            </ol>

            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add New Product
            </button>

            <!-- Product List Table -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-boxes me-1"></i>
                    Product List
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                            <?php
                            // Retrieve products from database
                            $sql = "SELECT * FROM products";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td><img src='uploads/{$row['image']}' alt='{$row['name']}' width='50' height='50' class='img-thumbnail'></td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['category']}</td>
                                            <td>\${$row['price']}</td>
                                            <td>{$row['stock']}</td>
                                            <td>
                                                <button onclick='editProduct({$row['id']})' class='btn btn-sm btn-warning'>Edit</button>
                                                <button onclick='deleteProduct({$row['id']})' class='btn btn-sm btn-danger'>Delete</button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No products found.</td></tr>";
                            }

                            $conn->close();
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

<!-- Modal for Adding Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="products.php" enctype="multipart/form-data" id="addProductForm">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Category</label>
                        <select class="form-control" id="productCategory" name="product_category" required>
                            <option value="Pizza">Pizza</option>
                            <option value="Appetizer">Appetizer</option>
                            <option value="Main Course">Main Course</option>
                            <option value="Wings">Wings</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Other Menu">Other Menu</option>
                            <option value="Drinks">Drinks</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="product_description" rows="3" required></textarea>
                    </div>

                    <!-- Conditional Fields -->
                    <div id="conditionalFields">
                        <!-- For Pizza: Sizes and Prices -->
                        <div class="mb-3" id="sizeField" style="display:none;">
                            <label for="productSize" class="form-label">Available Sizes</label>
                            <div id="pizzaSizes">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="product_size[]" placeholder="Size (e.g., Small)">
                                    <input type="number" step="0.01" class="form-control" name="product_size_price[]" placeholder="Price for size">
                                    <button type="button" class="btn btn-outline-secondary remove-size">Remove</button>
                                </div>
                            </div>
                            <button type="button" id="addSizeBtn" class="btn btn-outline-primary">Add another size</button>
                        </div>

                        <!-- For Appetizer: Flavors -->
                        <div class="mb-3" id="flavorOptions" style="display:none;">
                            <label for="flavorsAvailable" class="form-label">Are flavors available?</label>
                            <select class="form-control" id="flavorsAvailable" name="flavors_available">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                        <div class="mb-3" id="flavorField" style="display:none;">
                            <label for="productFlavors" class="form-label">Available Flavors</label>
                            <input type="text" class="form-control" id="productFlavors" name="product_flavors" placeholder="e.g., BBQ, Honey Mustard, Garlic Parmesan">
                        </div>

                        <!-- For Main Course: Alacarte or Main Course -->
                        <div class="mb-3" id="courseTypeField" style="display:none;">
                            <label for="courseType" class="form-label">Is it Alacarte or Main Course?</label>
                            <select class="form-control" id="courseType" name="course_type">
                                <option value="Alacarte">Alacarte</option>
                                <option value="Main Course">Main Course</option>
                            </select>
                        </div>
                        <div class="mb-3" id="portionField" style="display:none;">
                            <label for="productPortions" class="form-label">Available Portions</label>
                            <input type="text" class="form-control" id="productPortions" name="product_portions" placeholder="e.g., Single, Family, Party">
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="productPrice" name="product_price" required>
                    </div>

                    <!-- Stock -->
                    <div class="mb-3">
                        <label for="productStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="productStock" name="product_stock" required>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="product_image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
// Toastr options
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

// Handle Category Changes
document.getElementById('productCategory').addEventListener('change', function() {
    var category = this.value;
    // Hide all conditional fields initially
    document.getElementById('sizeField').style.display = 'none';
    document.getElementById('flavorOptions').style.display = 'none';
    document.getElementById('flavorField').style.display = 'none';
    document.getElementById('courseTypeField').style.display = 'none';
    document.getElementById('portionField').style.display = 'none';

    if (category === 'Pizza') {
        document.getElementById('sizeField').style.display = 'block';
    } else if (category === 'Appetizer') {
        document.getElementById('flavorOptions').style.display = 'block';
        document.getElementById('flavorsAvailable').addEventListener('change', function() {
            var flavorsAvailable = this.value;
            if (flavorsAvailable === 'Yes') {
                document.getElementById('flavorField').style.display = 'block';
            } else {
                document.getElementById('flavorField').style.display = 'none';
            }
        });
    } else if (category === 'Main Course') {
        document.getElementById('courseTypeField').style.display = 'block';
        document.getElementById('courseType').addEventListener('change', function() {
            var courseType = this.value;
            if (courseType === 'Main Course') {
                document.getElementById('portionField').style.display = 'block';
            } else {
                document.getElementById('portionField').style.display = 'none';
            }
        });
    }
});

// Add and Remove Pizza Sizes
document.getElementById('addSizeBtn').addEventListener('click', function() {
    var pizzaSizesDiv = document.getElementById('pizzaSizes');
    var newSizeInput = `
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="product_size[]" placeholder="Size (e.g., Small)">
            <input type="number" step="0.01" class="form-control" name="product_size_price[]" placeholder="Price for size">
            <button type="button" class="btn btn-outline-secondary remove-size">Remove</button>
        </div>
    `;
    pizzaSizesDiv.insertAdjacentHTML('beforeend', newSizeInput);
});

// Remove size row
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-size')) {
        e.target.parentNode.remove();
    }
});

// Add Product
$('#addProductForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    
    var formData = new FormData(this); // Get form data
    formData.append('action', 'add');  // Set the action to 'add'

    $.ajax({
        url: 'controller/products.php?action=add',
        type: 'POST',
        data: formData,
        contentType: false,  // Prevent jQuery from setting content type
        processData: false,  // Prevent jQuery from processing the data
        success: function(data) {
            if (data.success) {
                toastr.success('Product added successfully.');
                window.location.reload(); // Reload page to update the product list
            } else {
                toastr.error('Error: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Error: ' + error);
        }
    });
});

// Update Product
function updateProduct(productId) {
    var form = $('#updateProductForm_' + productId)[0];
    var formData = new FormData(form);
    formData.append('action', 'update');
    formData.append('product_id', productId);  // Attach product ID
    
    $.ajax({
        url: 'controller/products.php?action=update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.success) {
                toastr.success('Product updated successfully.');
                window.location.reload(); // Reload page to update the product list
            } else {
                toastr.error('Error: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Error: ' + error);
        }
    });
}

// Delete Product
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: 'controller/products.php?action=delete',
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(data) {
                if (data.success) {
                    toastr.success('Product deleted successfully.');
                    window.location.reload(); // Reload page to update the product list
                } else {
                    toastr.error('Error: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error: ' + error);
            }
        });
    }
}

</script>

<?php include('include/footer.php'); ?>
