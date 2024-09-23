<?php
include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>
<link rel="stylesheet" href="css/categories.css">
<body>  
<?php include('../include/nav.php'); ?>
<!-- Categories Container -->
<div class="categories">
    <div class="category-button" onclick="filterCategory('all')">
        <i class="fas fa-list"></i>
        <span>All</span>
    </div>
    <div class="category-button" onclick="filterCategory('pizza')">
        <i class="fas fa-pizza-slice"></i>
        <span>Pizza</span>
    </div>
    <div class="category-button" onclick="filterCategory('appetizer')">
        <i class="fas fa-utensils"></i>
        <span>Appetizer</span>
    </div>
    <div class="category-button" onclick="toggleSubMenu('main-course')">
        <i class="fas fa-drumstick-bite"></i>
        <span>Main Course</span>
        <!-- Submenu for Main Course -->
        <div id="main-course-submenu" class="submenu">
            <div class="submenu-item" onclick="filterCategory('main-course')">
                <span>Main Course</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('ala-carte')">
                <span>Ala Carte</span>
            </div>
        </div>
    </div>
    <div class="category-button" onclick="filterCategory('wings')">
        <i class="fas fa-drumstick-bite"></i>
        <span>Wings</span>
    </div>
    <div class="category-button" onclick="filterCategory('pasta')">
        <i class="fas fa-bacon"></i>
        <span>Pasta</span>
    </div>
    <div class="category-button" onclick="filterCategory('other-menu')">
        <i class="fas fa-hamburger"></i>
        <span>Other Menu</span>
    </div>
    <div class="category-button" onclick="toggleSubMenu('drinks')">
        <i class="fas fa-coffee"></i>
        <span>Drinks</span>
        <!-- Submenu for Drinks -->
        <div id="drinks-submenu" class="submenu">
            <div class="submenu-item" onclick="filterCategory('house-specials')">
                <span>House Specials</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('milktea-pearl')">
                <span>Milktea W/ Pearl</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('fruit-shakes')">
                <span>Fruit Shakes</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('fruit-tea-konjac')">
                <span>Fruit Tea W/ Konjac Jelly</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('flavored-juices')">
                <span>Flavored Juices</span>
            </div>
            <div class="submenu-item" onclick="filterCategory('fresh-tea')">
                <span>Fresh Tea</span>
            </div>
        </div>
    </div>
</div>

<!-- Food Items Section -->
<div class="food-section" id="food-section">
    <!-- Food items will be loaded here by AJAX -->
</div>

<!-- Order Modal -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Order Details</h2>
        <div class="modal-body">
            <div class="modal-item">
                <label for="item-name">Item:</label>
                <input type="text" id="item-name" readonly>
            </div>
            <div class="modal-item">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" min="1" value="1" onchange="calculateTotalAmount()" oninput="calculateTotalAmount()">
            </div>
            <div class="modal-item">
                <label for="order-type">Order Type:</label>
                <select id="order-type">
                    <option value="pickup">Pickup</option>
                    <option value="delivery">Delivery</option>
                </select>
            </div>
            <div id="delivery-address-section" class="modal-item" style="display: none;">
                <label for="delivery-address">Delivery Address:</label>
                <textarea id="delivery-address" placeholder="Enter your address"></textarea>
            </div>
            <div class="modal-item">
                <label for="payment-mode">Payment Mode:</label>
                <select id="payment-mode">
                    <option value="cash">Cash</option>
                    <option value="card">Credit Card</option>
                    <option value="gcash">GCash</option>
                    <option value="paymaya">PayMaya</option>
                </select>
            </div>
            <div class="modal-item">
                <label for="total-amount">Total Amount:</label>
                <input type="text" id="total-amount" readonly>
            </div>
            <button id="confirm-order" onclick="confirmOrder()">Confirm Order</button>
        </div>
    </div>
</div>

<script>
// Function to show the order modal
function openOrderModal(itemName) {
    document.getElementById("orderModal").style.display = "block";
    document.getElementById("item-name").value = itemName;
    
    const itemElement = document.querySelector('.food-item[data-name="' + itemName + '"]');
    const itemPrice = parseFloat(itemElement.getAttribute('data-price'));
    document.getElementById("total-amount").value = "₱" + itemPrice.toFixed(2);
    document.getElementById("quantity").dataset.price = itemPrice;
}

// Function to calculate and update the total amount
function calculateTotalAmount() {
    const quantity = parseInt(document.getElementById("quantity").value);
    const itemPrice = parseFloat(document.getElementById("quantity").dataset.price);
    const totalAmount = quantity * itemPrice;
    document.getElementById("total-amount").value = "₱" + totalAmount.toFixed(2);
}

document.getElementById("order-type").addEventListener("change", function() {
    const orderType = this.value;
    const deliveryAddressSection = document.getElementById("delivery-address-section");
    if (orderType === "delivery") {
        deliveryAddressSection.style.display = "block";
    } else {
        deliveryAddressSection.style.display = "none";
    }
});

function closeModal() {
    document.getElementById("orderModal").style.display = "none";
}

// Function to handle the order confirmation
function confirmOrder() {
    const itemName = document.getElementById("item-name").value;
    const quantity = parseInt(document.getElementById("quantity").value);
    const orderType = document.getElementById("order-type").value;
    const paymentMode = document.getElementById("payment-mode").value;
    const deliveryAddress = document.getElementById("delivery-address").value;
    const userId = "<?php echo $_SESSION['id']; ?>";
    const totalAmount = parseFloat(document.getElementById("total-amount").value.replace('₱', ''));

    if (orderType === "delivery" && deliveryAddress.trim() === "") {
        alert("Please provide a delivery address.");
        return;
    }

    const orderData = {
        itemName: itemName,
        quantity: quantity,
        orderType: orderType,
        paymentMode: paymentMode,
        deliveryAddress: orderType === "delivery" ? deliveryAddress : '',
        totalAmount: totalAmount,
        userId: userId
    };

    $.ajax({
        url: '../controller/orders.php?action=ordernow',
        type: 'POST',
        data: orderData,
        success: function(response) {
            alert(response);
            closeModal();
        },
        error: function(xhr, status, error) {
            alert("An error occurred while placing your order. Please try again.");
            console.error(error);
        }
    });
}

// Function to handle adding to cart
function addToCart(itemId, quantity = 1) {
    const userId = "<?php echo $_SESSION['id']; ?>";

    console.log("Add to Cart function called");
    console.log("Item ID:", itemId);
    console.log("Quantity:", quantity);
    console.log("User ID:", userId);

    $.ajax({
        url: '../controller/orders.php?action=addtocart',
        type: 'POST',
        data: {
            item_id: itemId,
            quantity: quantity,
            user_id: userId
        },
        success: function(response) {
            console.log("AJAX request successful. Response:", response);
            const res = JSON.parse(response);
            if (res.status === 'success') {
                alert('Item added to cart successfully!');
            } else {
                alert('Failed to add item to cart: ' + res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("An error occurred during the AJAX request.");
            console.error("Status:", status);
            console.error("Error:", error);
        }
    });
}

// Function to add click event listener for the Add to Cart buttons
function initializeAddToCartButtons() {
    const addToCartButtons = document.querySelectorAll('.cart-button');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            console.log("Add to Cart button clicked for Item ID:", itemId);
            addToCart(itemId);
        });
    });
}

// Call this function after loading the food items
document.addEventListener('DOMContentLoaded', function() {
    filterCategory('all'); // Load all items initially
    initializeAddToCartButtons(); // Initialize Add to Cart buttons
});

function filterCategory(category) {
    $.ajax({
        url: '../controller/fetch_food_items.php',
        type: 'POST',
        data: { category: category },
        success: function(response) {
            document.getElementById('food-section').innerHTML = response;
        },
        error: function(xhr, status, error) {
            console.error('Error loading category:', error);
            alert('Failed to load category items. Please try again.');
        }
    });
}

// Call filterCategory with 'all' on page load to display all items by default
document.addEventListener('DOMContentLoaded', function() {
    filterCategory('all');
});

function toggleSubMenu(category) {
    const submenu = document.getElementById(`${category}-submenu`);
    submenu.style.display = submenu.style.display === "none" || submenu.style.display === "" ? "flex" : "none";
}

function toggleInfo(infoId) {
    var infoText = document.getElementById(infoId);
    infoText.classList.toggle('active');
}
</script>

<?php include('../include/foot.php'); ?>
</body>
</html>
