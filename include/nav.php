<?php
include('db_connect.php');

// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']);
$cart_count = 0;

// If the user is logged in, fetch the count of items in the cart
if ($is_logged_in) {
    $userId = $_SESSION['id'];
    $sql = "SELECT SUM(quantity) AS total_quantity FROM cart_items WHERE user_id = '$userId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cart_count = $row['total_quantity'] ?? 0; // Set cart_count to 0 if total_quantity is NULL
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <span class="flaticon-pizza-1 mr-1"></span>La Farina<br>
      <small>EST. 2022</small>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active"><a href="../index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="menulandingpage.php" class="nav-link">Menu</a></li>
        <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
        <li class="nav-item"><a href="customize.php" class="nav-link">Customize</a></li>
        <li class="nav-item"><a href="Pizza of the week.php" class="nav-link">Weekly Favorite</a></li>
      </ul>

      <!-- Dynamic Menu Based on Login Status -->
      <?php if ($is_logged_in): ?>
      <!-- If user is logged in, show this menu -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="cart.php" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="d-lg-none">Add to Cart</span>
            <?php if ($cart_count > 0): ?>
              <span class="badge badge-danger" id="cart-count"><?php echo $cart_count; ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> <span id="user-name"><?php echo $_SESSION['username']; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="orders.php"><i class="fas fa-box mr-2"></i> Orders</a>
            <a class="dropdown-item" href="settings.php"><i class="fas fa-cog mr-2"></i> Account Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
          </div>
        </li>
      </ul>
      <?php else: ?>
      <!-- If user is not logged in, show only login button -->
      <ul class="navbar-nav">
        <li class="nav-item"><a href="../login.php" class="nav-link"><i class="fas fa-user"></i> Login</a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>
