<?php

include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<link rel="stylesheet" href="css/categories.css">
<body>  
<?php
include('../include/nav.php');
?><!-- Categories Container -->
<div class="categories">
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

<!-- Pizza Section -->
<div class="food-section pizza">
<?php
$sql = "SELECT * FROM products WHERE category = 'Pizza'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="../uploads/' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No pizzas found.";
}
?>
</div>

<div class="food-section appetizer">
<?php
$sql = "SELECT * FROM products WHERE category = 'Appetizer'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="../uploads/' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button" onclick="openOrderModal(\'' . $row['name'] . '\')">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No appetizers found.";
}
?>
</div>

<div class="food-section main-course">
<?php
$sql = "SELECT * FROM products WHERE category = 'Main Course'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No main courses found.";
}
?>
</div>

<div class="food-section ala-carte">
<?php
$sql = "SELECT * FROM products WHERE category = 'Ala Carte'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No ala carte items found.";
}
?>
</div>

<div class="food-section wings">
<?php
$sql = "SELECT * FROM products WHERE category = 'Wings'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No wings found.";
}
?>
</div>
<!-- Pasta Section -->
<div class="food-section pasta">
<?php
$sql = "SELECT * FROM products WHERE category = 'Pasta'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No pasta items found.";
}
?>
</div>

<!-- House Specials Section -->
<div class="food-section house-specials">
<?php
$sql = "SELECT * FROM products WHERE category = 'House Specials'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No house specials found.";
}
?>
</div>

<!-- Milktea Pearl Section -->
<div class="food-section milktea-pearl">
<?php
$sql = "SELECT * FROM products WHERE category = 'Milktea Pearl'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '<a href="customize.php?item=' . $row['id'] . '" class="customize-button">Customize</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No milktea pearl items found.";
}
?>
</div>

<!-- Fruit Shakes Section -->
<div class="food-section fruit-shakes">
<?php
$sql = "SELECT * FROM products WHERE category = 'Fruit Shakes'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No fruit shakes found.";
}
?>
</div>

<!-- Flavored Juices Section -->
<div class="food-section flavored-juices">
<?php
$sql = "SELECT * FROM products WHERE category = 'Flavored Juices'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No flavored juices found.";
}
?>
</div>

<!-- Fruit Tea W/ Konjac Section -->
<div class="food-section fruit-tea-konjac">
<?php
$sql = "SELECT * FROM products WHERE category = 'Fruit Tea W/ Konjac'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No fruit tea konjac items found.";
}
?>
</div>

<!-- Fresh Tea Section -->
<div class="food-section fresh-tea">
<?php
$sql = "SELECT * FROM products WHERE category = 'Fresh Tea'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="size-label">Choose Size:</div>';
        echo '<div class="size-buttons">';
        $sizes = json_decode($row['sizes'], true);
        if ($sizes) {
            foreach ($sizes as $size) {
                echo '<button onclick="updateMenuItem(\'' . $row['id'] . '\', ' . $size . ')">' . $size . '"</button>';
            }
        }
        echo '</div>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No fresh tea items found.";
}
?>
</div>

<!-- Other Menu Section -->
<div class="food-section other-menu">
<?php
$sql = "SELECT * FROM products WHERE category = 'Other Menu'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<div class="image-container">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<div class="info-icon" data-info="Ingredients: ' . $row['description'] . '" onclick="toggleInfo(\'' . $row['id'] . '-info\')">ℹ️</div>';
        echo '<div id="' . $row['id'] . '-info" class="info-text"></div>';
        echo '<p>Price: ₱' . $row['price'] . '</p>';
        echo '<div class="action-buttons">';
        echo '<a href="#" class="order-button">Order Now</a>';
        echo '<a href="#" class="cart-button">Add to Cart</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No other menu items found.";
}
?>
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
                <input type="number" id="quantity" min="1" value="1">
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
            <button id="confirm-order" onclick="confirmOrder()">Confirm Order</button>
        </div>
    </div>
</div>


</div>

<script>
// Function to show the order modal
function openOrderModal(itemName) {
    document.getElementById("orderModal").style.display = "block";
    document.getElementById("item-name").value = itemName;
}

// Function to close the order modal
function closeModal() {
    document.getElementById("orderModal").style.display = "none";
}

// Event listener to handle showing/hiding the delivery address field
document.getElementById("order-type").addEventListener("change", function() {
    const orderType = this.value;
    const deliveryAddressSection = document.getElementById("delivery-address-section");
    
    if (orderType === "delivery") {
        deliveryAddressSection.style.display = "block";
    } else {
        deliveryAddressSection.style.display = "none";
    }
});

// Function to handle the order confirmation
function confirmOrder() {
    const itemName = document.getElementById("item-name").value;
    const quantity = document.getElementById("quantity").value;
    const orderType = document.getElementById("order-type").value;
    const paymentMode = document.getElementById("payment-mode").value;
    const deliveryAddress = document.getElementById("delivery-address").value;
    const userId = "<?php echo $_SESSION['id']; ?>"; // Assuming you have stored the user ID in the session

    // Validate the required fields
    if (orderType === "delivery" && deliveryAddress.trim() === "") {
        alert("Please provide a delivery address.");
        return;
    }

    // Prepare the data to be sent
    const orderData = {
        itemName: itemName,
        quantity: quantity,
        orderType: orderType,
        paymentMode: paymentMode,
        deliveryAddress: orderType === "delivery" ? deliveryAddress : '',
        userId: userId
    };

    // Send the data using AJAX
    $.ajax({
        url: '../controller/orders.php?action=ordernow',
        type: 'POST',
        data: orderData,
        success: function(response) {
            // Handle success response from server
            alert(response); // Display success message
            closeModal();
        },
        error: function(xhr, status, error) {
            // Handle error response from server
            alert("An error occurred while placing your order. Please try again.");
            console.error(error);
        }
    });
}

// Event listener to close the modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById("orderModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

function filterCategory(category) {
    var sections = document.querySelectorAll('.food-section');
    sections.forEach(function(section) {
        if (section.classList.contains(category)) {
            section.style.display = 'flex';
        } else {
            section.style.display = 'none';
        }
    });
}

// Function to toggle submenu visibility
function toggleSubMenu(category) {
    const submenu = document.getElementById(`${category}-submenu`);
    if (submenu.style.display === "none" || submenu.style.display === "") {
        submenu.style.display = "flex";
    } else {
        submenu.style.display = "none";
    }
}

// Function to toggle info text
function toggleInfo(infoId) {
    var infoText = document.getElementById(infoId);
    infoText.classList.toggle('active');
}



var selectedAddons = {};

function toggleAddon(item, addonButton) {
    var addonName = addonButton.dataset.addon;
    var addonPrice = parseFloat(addonButton.dataset.price);
    var imageURL = addonButton.dataset.image;
    var addButton = addonButton; // Use addonButton as event.currentTarget is not defined here
    var itemKey = item + '-addons';

    if (!selectedAddons[itemKey]) {
        selectedAddons[itemKey] = {
            selected: [],
            price: 0
        };
    }
    var isAlreadyAdded = addButton.classList.contains('selected');
    var addonIndex = selectedAddons[itemKey].selected.indexOf(addonName);

    if (!isAlreadyAdded && selectedAddons[itemKey].selected.length < 2) {
        // Add add-on price to total price
        var priceElement = document.getElementById(item + '-price');
        var currentPrice = parseFloat(priceElement.innerText.replace('₱', ''));
        var newPrice = currentPrice + addonPrice;
        priceElement.innerText = '₱' + newPrice.toFixed(2);

        // Apply selected add-ons price
        selectedAddons[itemKey].price += addonPrice;

        // Show popup image for 3 seconds
        var popupImage = document.createElement('img');
        popupImage.src = imageURL;
        popupImage.alt = addonName + ' Image';
        popupImage.classList.add('addon-popup-image');
        addButton.appendChild(popupImage);

        // Add add-on to selected list
        selectedAddons[itemKey].selected.push(addonName);

        // Toggle selected class for button
        addButton.classList.add('selected');

        // Add selected add-on to selected-addons section with remove button
        var selectedAddonsContainer = document.getElementById('selected-addons-' + item);
        var selectedAddonItem = document.createElement('div');
        selectedAddonItem.classList.add('selected-addon-item');
        selectedAddonItem.textContent = addonName;
        
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('remove-addon-button');
        removeButton.addEventListener('click', function() {
            // Remove add-on from selected list
            selectedAddons[itemKey].selected.splice(addonIndex, 1);

            // Remove selected add-on from UI
            selectedAddonItem.remove();

            // Remove add-on price from total price
            var currentPrice = parseFloat(priceElement.innerText.replace('₱', ''));
            var newPrice = currentPrice - addonPrice;
            priceElement.innerText = '₱' + newPrice.toFixed(2);

            // Remove selected class for button
            addButton.classList.remove('selected');

            // Enable all add-on buttons
            var addOnButtons = document.querySelectorAll('.food-section.' + item + ' .add-ons-buttons button');
            addOnButtons.forEach(function(button) {
                button.disabled = false;
            });
        });
        
        selectedAddonItem.appendChild(removeButton);
        selectedAddonsContainer.appendChild(selectedAddonItem);

        // Remove add-on and popup image after 3 seconds
        setTimeout(function() {
            addButton.removeChild(popupImage);
        }, 3000);
    } else if (isAlreadyAdded) {
        // Remove add-on price from total price (if deselected)
        var priceElement = document.getElementById(item + '-price');
        var currentPrice = parseFloat(priceElement.innerText.replace('₱', ''));
        var newPrice = currentPrice - addonPrice;
        priceElement.innerText = '₱' + newPrice.toFixed(2);

        // Remove add-on from selected list
        selectedAddons[itemKey].selected.splice(addonIndex, 1);

        // Apply selected add-ons price
        selectedAddons[itemKey].price -= addonPrice;

        // Remove selected class for button
        addButton.classList.remove('selected');

        // Remove selected add-on from UI
        var selectedAddonsContainer = document.getElementById('selected-addons-' + item);
        var selectedAddonItems = selectedAddonsContainer.getElementsByClassName('selected-addon-item');
        for (var i = 0; i < selectedAddonItems.length; i++) {
            if (selectedAddonItems[i].textContent === addonName) {
                selectedAddonItems[i].remove();
                break;
            }
        }
    }

    // Disable other add-ons buttons if two are selected
    var addOnButtons = document.querySelectorAll('.food-section.' + item + ' .add-ons-buttons button');
    addOnButtons.forEach(function(button) {
        var addon = button.dataset.addon;
        if (!button.classList.contains('selected') && selectedAddons[itemKey].selected.length >= 2 && selectedAddons[itemKey].selected.indexOf(addon) === -1) {
            button.disabled = true;
        } else {
            button.disabled = false;
        }
    });
}// Select all add to cart buttons
const addToCartButtons = document.querySelectorAll('.add-to-cart');

// Add click event listener to each button
addToCartButtons.forEach(button => {
    button.addEventListener('click', addToCartClicked);
});

// Function to handle click event
function addToCartClicked(event) {
    const button = event.target;
    const productId = button.dataset.id; // Get the product ID from the button's data-id attribute

    addToCart(productId);
}



       
</script>
 <?php include('../include/foot.php');?>
</body>
</html>


