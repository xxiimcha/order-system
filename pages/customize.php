<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pizza - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Link to Bootstrap CSS and other stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Add custom CSS for spinning animation -->
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spin-image {
            animation: spin 5s linear infinite;
        }

        .hero-header {
            background-image: url('bg2.jpg');
            background-size: 100% 100%; /* Adjusted */
            background-position: center;
            background-repeat: no-repeat; /* Added */
        }

        body {
            margin: 0;
        }

        .container-xxl {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- Your navbar -->
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container">
    <!-- Navbar Brand and Toggler -->
    <a class="navbar-brand" href="index.html">
      <span class="flaticon-pizza-1 mr-1"></span>La Farina<br>
      <small>EST. 2022</small>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <!-- Navbar Collapse Content -->
    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="menulandingpage.html" class="nav-link">Menu</a></li>
        <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
        <li class="nav-item active"><a href="customize.html" class="nav-link">Customize</a></li>
        <li class="nav-item"><a href="Pizza of the week.html" class="nav-link">Weekly Favorite</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> <span id="user-name"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="profile.html">Profile</a>
            <a class="dropdown-item" href="orders.html">Orders</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.html">Logout</a>
          </div>
        </li>
        <li class="nav-item"><a href="cart.html" class="nav-link"><i class="fas fa-shopping-cart"></i> <span class="d-lg-none">Add to Cart</span></a></li>
         <li class="nav-item">
            <a href="messages.html" class="nav-link">
              <i class="fas fa-envelope"></i> Messages
              <span id="message-count" class="badge badge-danger">0</span>
            </a>
          </li>
      </ul>
    </div>
  </div>
</nav>


    <!-- Your hero section with spinning image -->
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Customize Your Own Pizza</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">Unleash your inner chef and embark on a culinary adventure like no other with our 'Customize Your Own Pizza' option. Picture this: you're the mastermind behind every delectable detail, from the crust to the toppings and everything in between.</p>
                    <a href="pizzacus.html" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Customize</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid spin-image" src="izz.png" alt="">
                </div>
            </div>
        </div>
    </div>

 
    <!-- Link to Bootstrap JS and other scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

