<?php
include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<link rel="stylesheet" href="css/custom-pizza.css">
<body>
<?php include('../include/nav.php');?>
<br>
<div class="custom-container">
    <h1>Customize Your Pizza</h1>
    <div>
        <label for="flavor-count">Pizza Size:</label>
        <select id="flavor-count">
            <option value="18">18"</option>
            <option value="24">24"</option>
            <option value="30">30"</option>
            <option value="36">36"</option>
        </select>
    </div>
    <div id="pizza-info">
    <!-- Price and information will be displayed here -->
</div>
<div id="error-message" class="error-message"></div>
<br>
    <div class="pizza-customization">
        <div class="pizza" id="pizza">
            <img src="https://via.placeholder.com/600x600.png?text=Pizza+Base" alt="Pizza Base" class="pizza-base">
            <div class="pizza-section top-half" data-section="top-half">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section bottom-half" data-section="bottom-half">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section top-left" data-section="top-left">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section top-middle" data-section="top-middle">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section top-right" data-section="top-right">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section bottom-left" data-section="bottom-left">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section bottom-middle" data-section="bottom-middle">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
            <div class="pizza-section bottom-right" data-section="bottom-right">
                <img src="" alt="Flavor Image" style="display: none;">
            </div>
        </div>
        <div class="flavor-selection">
            <h3>Select Flavor:</h3>
            <ul id="flavor-list">
                <li data-flavor="Savory Pepperoni" data-img="../assets/Pepp.jpg">Savory Pepperoni</li>
                <li data-flavor="Aloha Hawaiian" data-img="../assets/sample.jpg">Aloha Hawaiian</li>
                <li data-flavor="B&M Bacon and Mushroom" data-img="../assets/BM.jpg">B&M Bacon and Mushroom</li>
                <li data-flavor="Meaty Mighty" data-img="../assets/Meat.jpg">Meaty Mighty</li>
                <li data-flavor="Quad Cheese" data-img="../assets/quad.jpg">Quad Cheese</li>
                <li data-flavor="Cheesy Spinach" data-img="../assets/cheesyspi.jpg">Cheesy Spinach</li>
                <li data-flavor="La Suprema" data-img="../assets/Suprema.jpg">La Suprema</li>
                <li data-flavor="Marhaba Shawarma" data-img="../assets/shaw.jpg">Marhaba Shawarma</li>
                <li data-flavor="Spicy Buffalo Chicken" data-img="../assets/spibuf.jpg">Spicy Buffalo Chicken</li>
                <li data-flavor="Butter Garlic Shrimp" data-img="../assets/Shrimp.jpg">Butter Garlic Shrimp</li>
            </ul>
        </div>
    </div>
    <div>
    <label for="pizza-name">Pizza Name:</label>
    <input type="text" id="pizza-name" placeholder="Enter your pizza name">
</div>


    <div class="order-section">
        <button id="order-btn" class="btn">Proceed To Checkout</button>
    </div>
    <div id="order-details" class="order-details">
        <h2>Order Details</h2>
        <p id="order-summary"></p>
        <div id="flavor-summary"></div>
        
        <!-- Delivery or Pickup Options -->
        <div style="margin-top: 10px;">
            <label for="delivery-mode">Delivery Mode:</label>
            <select id="delivery-mode" class="styled-select">
                <option value="pickup">Pickup</option>
                <option value="delivery">Delivery</option>
            </select>
        </div>
        
        <!-- Address Input (Hidden initially) -->
        <div id="address-container" style="display: none; margin-top: 10px;">
            <label for="delivery-address">Delivery Address:</label>
            <input type="text" id="delivery-address" placeholder="Enter your delivery address" class="styled-input">
        </div>
        
        <!-- Payment Mode Options -->
        <div style="margin-top: 10px;">
            <label for="payment-mode">Payment Mode:</label>
            <select id="payment-mode" class="styled-select">
                <option value="cash">Cash</option>
                <option value="cashless">Cashless</option>
            </select>
        </div>

        <div class="order-btns" style="margin-top: 20px;">
            <button id="add-to-cart-btn" class="btn add-to-cart-btn">Place Order</button>
            <button id="close-btn" class="btn close-btn">Close</button>
        </div>
    </div>
</div>

 <div id="pizza-box" style="display: none;">
    <div id="box-message">Your order is being processed...</div>
    <img id="lafbox" src="../assets/lafbox.png" alt="Pizza Box">
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Define all necessary variables
    const flavorList = document.getElementById('flavor-list');
    const pizzaSections = document.querySelectorAll('.pizza-section');
    const pizza = document.getElementById('pizza');
    const orderBtn = document.getElementById('order-btn');
    const orderDetails = document.getElementById('order-details');
    const closeBtn = document.getElementById('close-btn');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const flavorSummary = document.getElementById('flavor-summary');
    const orderSummary = document.getElementById('order-summary');
    const pizzaSizeSelect = document.getElementById('flavor-count');
    const pizzaNameInput = document.getElementById('pizza-name');
    const pizzaInfo = document.getElementById('pizza-info');
    const errorMessage = document.getElementById('error-message');
    const pizzaBox = document.getElementById('pizza-box');
    const deliveryModeSelect = document.getElementById('delivery-mode');
    const addressContainer = document.getElementById('address-container');
    const deliveryAddressInput = document.getElementById('delivery-address');
    const paymentModeSelect = document.getElementById('payment-mode');

    let selectedSection = null;
    let selectedFlavors = {}; // Store selected flavors
    let previousPizzaSize = null;

    const pizzaSizes = {
        '18': { price: 659, flavors: 2, servings: '8-11 pax' },
        '24': { price: 1099, flavors: 2, servings: '10-15 pax' },
        '30': { price: 1799, flavors: 4, servings: '15-20 pax' },
        '36': { price: 2699, flavors: 6, servings: '20-25 pax' }
    };

    // Update pizza size and display the appropriate sections and information
    function updatePizzaSize() {
        const pizzaSize = pizzaSizeSelect.value;
        pizza.className = 'pizza size-' + pizzaSize;
        pizzaSections.forEach(section => section.style.display = 'none');

        // Display sections based on the selected size
        switch (pizzaSize) {
            case '18':
            case '24':
                pizza.querySelector('.top-half').style.display = 'flex';
                pizza.querySelector('.bottom-half').style.display = 'flex';
                break;
            case '30':
                pizza.querySelector('.top-left').style.display = 'flex';
                pizza.querySelector('.top-right').style.display = 'flex';
                pizza.querySelector('.bottom-left').style.display = 'flex';
                pizza.querySelector('.bottom-right').style.display = 'flex';
                break;
            case '36':
                pizza.querySelector('.top-left').style.display = 'flex';
                pizza.querySelector('.top-middle').style.display = 'flex';
                pizza.querySelector('.top-right').style.display = 'flex';
                pizza.querySelector('.bottom-left').style.display = 'flex';
                pizza.querySelector('.bottom-middle').style.display = 'flex';
                pizza.querySelector('.bottom-right').style.display = 'flex';
                break;
        }

        // Display price and info
        pizzaInfo.innerHTML = `
            <p>Price: ${pizzaSizes[pizzaSize].price} pesos</p>
            <p>Flavors: ${pizzaSizes[pizzaSize].flavors}</p>
            <p>Servings: ${pizzaSizes[pizzaSize].servings}</p>
        `;

        // Clear previously selected flavors if switching pizza size
        if (previousPizzaSize && pizzaSize !== previousPizzaSize) {
            clearSelectedFlavors();
        }

        previousPizzaSize = pizzaSize;
    }

    // Event listener to update pizza size selection
    pizzaSizeSelect.addEventListener('change', updatePizzaSize);

    // Highlight selected pizza section for flavor assignment
    pizzaSections.forEach(section => {
        section.addEventListener('click', function () {
            selectedSection = section;
            flavorList.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
            section.classList.add('selected'); // Highlight the selected section
        });
    });

    // Select flavor for the chosen pizza section
    flavorList.addEventListener('click', function (e) {
        if (e.target.tagName === 'LI' && selectedSection) {
            const flavor = e.target.dataset.flavor;
            const img = e.target.dataset.img;
            selectedSection.querySelector('img').src = img;
            selectedSection.querySelector('img').style.display = 'block';
            selectedFlavors[selectedSection.dataset.section] = { flavor, img };
            flavorList.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
            e.target.classList.add('selected');
        }
    });

    // Show or hide the address input field based on delivery mode selection
    deliveryModeSelect.addEventListener('change', function () {
        if (deliveryModeSelect.value === 'delivery') {
            addressContainer.style.display = 'block';
        } else {
            addressContainer.style.display = 'none';
            deliveryAddressInput.value = ''; // Clear address input if not needed
        }
    });

    // Display order details when "Proceed to Checkout" is clicked
    orderBtn.addEventListener('click', function () {
        if (!pizzaNameInput.value.trim()) {
            displayErrorMessage('Please enter a name for your pizza.');
            return;
        }

        const requiredFlavors = pizzaSizes[pizzaSizeSelect.value].flavors;
        const selectedCount = Object.keys(selectedFlavors).length;
        if (selectedCount !== requiredFlavors) {
            displayErrorMessage(`Please select ${requiredFlavors} flavors for your pizza.`);
            return;
        }

        orderDetails.style.display = 'block';
        errorMessage.style.display = 'none';
        flavorSummary.innerHTML = '';
        Object.keys(selectedFlavors).forEach(section => {
            const p = document.createElement('p');
            const img = document.createElement('img');
            img.src = selectedFlavors[section].img;
            img.style.width = '50px';
            img.style.height = '50px';
            p.textContent = `${section}: ${selectedFlavors[section].flavor}`;
            flavorSummary.appendChild(p);
            flavorSummary.appendChild(img);
        });

        orderSummary.innerHTML = `Pizza Size: ${pizzaSizeSelect.value}"<br>`;
        orderSummary.innerHTML += `Pizza Name: ${pizzaNameInput.value}<br>`;
        orderSummary.innerHTML += `Price: ${pizzaSizes[pizzaSizeSelect.value].price} pesos`;
    });

    // Close the order details modal
    closeBtn.addEventListener('click', function () {
        orderDetails.style.display = 'none';
        errorMessage.style.display = 'none';
    });

    // Place order and show pizza box animation
    addToCartBtn.addEventListener('click', placeCustomizedOrder);

    // Function to handle placing customized pizza order
    function placeCustomizedOrder() {
        const pizzaName = pizzaNameInput.value.trim();
        const pizzaSize = pizzaSizeSelect.value;
        const flavors = Object.values(selectedFlavors).map(flavor => flavor.flavor).join(", ");
        const totalAmount = pizzaSizes[pizzaSize].price;
        const paymentMode = paymentModeSelect.value;
        const deliveryMode = deliveryModeSelect.value;
        let deliveryAddress = deliveryMode === 'delivery' ? deliveryAddressInput.value.trim() : 'Pickup';
        const userId = "<?php echo $_SESSION['id']; ?>"; // Assuming user_id is stored in session when logged in

        // Validate the delivery address if delivery mode is selected
        if (deliveryMode === 'delivery' && !deliveryAddress) {
            displayErrorMessage('Please provide a delivery address.');
            return;
        }

        // Send the AJAX request to place the customized order
        $.ajax({
            url: '../controller/orders.php?action=placeCustomizedOrder',
            type: 'POST',
            data: {
                pizzaName: pizzaName,
                pizzaSize: pizzaSize,
                flavors: flavors,
                paymentMode: paymentMode,
                deliveryAddress: deliveryAddress,
                userId: userId,
                totalAmount: totalAmount,
                deliveryMode: deliveryMode
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.success) {
                    alert("Customized order placed successfully! Your order number is: " + res.order_number);
                    window.location.href = 'order-summary.html'; // Example redirection after order placement
                } else {
                    alert("Error: " + res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error placing customized order:', error);
                alert("Error placing order. Please try again.");
            }
        });
    }

    // Function to clear selected flavors
    function clearSelectedFlavors() {
        selectedFlavors = {};
        flavorSummary.innerHTML = '';
        pizzaSections.forEach(section => {
            const img = section.querySelector('img');
            img.src = '';
            img.style.display = 'none';
        });
    }

    // Function to display error messages
    function displayErrorMessage(message) {
        errorMessage.innerHTML = message;
        errorMessage.style.display = 'block';
    }

    // Initialize pizza size and flavors
    updatePizzaSize();
});
</script>

</body>
</html>



