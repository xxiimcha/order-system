<?php

// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<!DOCTYPE php>
<php lang="en">
  <head>
    <title>La Farina</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


     <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">   

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Libraries Stylesheet -->
    <link href="libmlk/animate/animate.min.css" rel="stylesheet">
    <link href="libmlk/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="libmlk/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="cssmlk/bootstrap.minmlk.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="cssmlk/stylemlk.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">   
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
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
    

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  <?php
  include('include/db_connect.php');

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
      <a class="navbar-brand" href="index.php">
        <span class="flaticon-pizza-1 mr-1"></span>La Farina<br>
        <small>EST. 2022</small>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="pages/menulandingpage.php" class="nav-link">Menu</a></li>
          <li class="nav-item"><a href="pages/services.php" class="nav-link">Services</a></li>
          <li class="nav-item"><a href="pages/customize.php" class="nav-link">Customize</a></li>
          <li class="nav-item"><a href="pages/Pizza of the week.php" class="nav-link">Weekly Favorite</a></li>
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
              <a class="dropdown-item" href="pages/profile.php"><i class="fas fa-user-circle mr-2"></i> Profile</a>
              <a class="dropdown-item" href="pages/orders.php"><i class="fas fa-box mr-2"></i> Orders</a>
              <a class="dropdown-item" href="pages/settings.php"><i class="fas fa-cog mr-2"></i> Settings</a>
              <a class="dropdown-item" href="pages/messages.php">
                <i class="fas fa-envelope mr-2"></i> Messages
                <span id="message-count" class="badge badge-danger">0</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
          </li>
        </ul>
        <?php else: ?>
        <!-- If user is not logged in, show only login button -->
        <ul class="navbar-nav">
          <li class="nav-item"><a href="login.php" class="nav-link"><i class="fas fa-user"></i> Login</a></li>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </nav>

    <!-- END nav -->

    <section class="home-slider owl-carousel img" style="background-image: url(images/bg_1.jpg);">
  <div class="slider-item">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text align-items-center" data-scrollax-parent="true">
        <div class="col-md-6 col-sm-12 ftco-animate">
          <span class="subheading">Delicious</span>
          <h1 class="mb-4">Cheesy Spinach</h1>
          <p class="mb-4 mb-md-5">You simply must experience the irresistible flavors of our pizza – it's a culinary journey you won't want to miss!</p>
          <p><a href="#" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a> <a href="menu1.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
        </div>
        <div class="col-md-6 ftco-animate">
          <img src="images/bg_1.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>

  <div class="slider-item">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text align-items-center" data-scrollax-parent="true">
        <div class="col-md-6 col-sm-12 order-md-last ftco-animate">
          <span class="subheading">Crunchy</span>
          <h1 class="mb-4">Savory Pepperoni</h1>
          <p class="mb-4 mb-md-5">Embark on a culinary escapade and savor the irresistible allure of our Savory Pepperoni pizza – a taste sensation that demands to be experienced firsthand.</p>
          <p><a href="#" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a> <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
        </div>
        <div class="col-md-6 ftco-animate">
          <img src="images/bg_2.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>

  <div class="slider-item" style="background-image: url(vid2.gif);">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <span class="subheading">Welcome</span>
          <h1 class="mb-4">We cooked your desired Pizza Recipe</h1>
          <p class="mb-4 mb-md-5">Treat yourself to a mouthwatering adventure with our sensational pizza, guaranteed to tantalize your taste buds and leave you craving another slice.</p>
          <p><a href="#" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</a> <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">View Menu</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
    <section class="ftco-intro">
      <div class="container-wrap">
        <div class="wrap d-md-flex">
          <div class="info">
            <div class="row no-gutters">
              <div class="col-md-4 d-flex ftco-animate">
                <div class="icon"><span class="icon-phone"></span></div>
                <div class="text">
                  <h3>0905 260 0388</h3>
                  <p>Contact Us!</p>
                </div>
              </div>
              <div class="col-md-3 d-flex ftco-animate">
                <div class="icon"><span class="icon-my_location"></span></div>
                <div class="text">
                  <h3>Mexico, Pampanga</h3>
                  <p>Maningning Street 1st floor, NONO's Commercial Building, Santo Domingo</p>
                </div>
              </div>
              <div class="col-md-4 d-flex ftco-animate">
                <div class="icon"><span class="icon-clock-o"></span></div>
                <div class="text">
                  <h3>Open Monday-Sunday</h3>
                  <p>10:00am - 8:00pm</p>
                </div>
              </div>
            </div>
          </div>
          <div class="social d-md-flex pl-md-5 p-4 align-items-center">
            <ul class="social-icon">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

 <section class="ftco-about d-md-flex">
    	<div class="one-half img" style="background-image: url(homepage.jpg);"></div>
    	<div class="one-half ftco-animate">
        <div class="heading-section ftco-animate ">
          <h2 class="mb-4">Welcome to <span class="flaticon-pizza">La Farina<br></span>EST. 2022</h2>
        </div>
        <div>
  				<p>La Farina prides itself on its diverse menu, showcasing an enticing array of culinary delights. From tender chicken and flavorful pasta to crispy fries and indulgent milk tea, their offerings cater to a wide range of tastes. However, it's their signature pizzas that truly stand out, crafted with care and customizable to satisfy every craving. Whether you're a traditionalist or an adventurous eater, La Farina ensures a dining experience that delights the senses and leaves you craving more.</p>
  			</div>
    	</div>
    </section>

    <section class="ftco-section ftco-services">
    	<div class="overlay"></div>
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <h2 class="mb-4">Our Services</h2>
            <p>Unveil excellence through our stellar services, tailored to exceed your expectations.</p>
          </div>
        </div>
    	<div class="row">
  <div class="col-md-4 ftco-animate">
    <div class="media d-block text-center block-6 services">
      <div class="icon d-flex justify-content-center align-items-center mb-5">
        <a href="link_to_your_catering_service"><span class="flaticon-diet"></span></a>
      </div>
      <div class="media-body">
        <h3 class="heading">Catering Service</h3>
        <p>We accept Catering Services and Party Packages Orders!</p>
      </div>
    </div>      
  </div>
  <div class="col-md-4 ftco-animate">
    <div class="media d-block text-center block-6 services">
      <div class="icon d-flex justify-content-center align-items-center mb-5">
        <a href="link_to_your_delivery_service"><span class="flaticon-bicycle"></span></a>
      </div>
      <div class="media-body">
        <h3 class="heading">Delivery</h3>
        <p>Experience the convenience of food delivery, bringing delicious meals right to your doorstep, ensuring satisfaction with every bite.</p>
      </div>
    </div>      
  </div>
  <div class="col-md-4 ftco-animate">
    <div class="media d-block text-center block-6 services">
      <div class="icon d-flex justify-content-center align-items-center mb-5">
        <a href="menu1.php"><span class="flaticon-pizza-1"></span></a>
      </div>
      <div class="media-body">
        <h3 class="heading">Our Menu</h3>
        <p>Discover the variety of appetizing foods and products we offer, ensuring there's a delightful option for every palate to explore and savor.</p>
      </div>
    </div>    
  </div>
</div>

    </section>
<style>
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-price {
        font-size: 1.1rem;
        color: #777;
    }

    .btn-primary {
        background-color: #ff6700;
        border-color: #ff6700;
    }

    .btn-primary:hover {
        background-color: #e65c00;
        border-color: #e65c00;
    }

.home-slider {
    overflow: hidden;
  }

  .slider-item {
    min-height: 50vh;
    display: flex;
    align-items: center;
  }

  .slider-text {
    padding: 0 15px;
  }

  .img-fluid {
    max-width: 100%;
    height: auto;
  }

  @media (max-width: 767.98px) {
    .slider-text {
      text-align: center;
    }

    .slider-text .col-md-6,
    .slider-text .col-md-7 {
      text-align: center;
      margin-bottom: 20px;
    }

    .slider-text .btn {
      display: block;
      width: 100%;
      margin-bottom: 10px;
    }
  }

  .navbar-nav .nav-item .nav-link i.fas {
    margin-right: 5px;
  }
  .navbar-nav .nav-item.dropdown .dropdown-toggle::after {
    margin-left: 5px;
  }
  .navbar-nav .nav-item.dropdown .dropdown-menu {
    background-color: #343a40; /* Dark background */
    border: none; /* Remove default border */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow */
  }
  .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-item {
    color: #fff; /* White text */
  }
  .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-item:hover {
    background-color: #495057; /* Darker background on hover */
    color: #fff; /* Keep text white on hover */
  }
  .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-divider {
    border-top: 1px solid #495057; /* Darker divider */
  }
  .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-item i {
    margin-right: 10px; /* Add margin to icons in the dropdown */
  }

  /* Ensure dropdown and buttons are responsive */
  @media (max-width: 767.98px) {
    .navbar-nav .nav-item .nav-link {
      padding-left: 0;
      padding-right: 0;
    }
    .navbar-nav .nav-item.dropdown .dropdown-menu {
      position: static; /* Make dropdown static in mobile view */
      float: none;
    }
  }

  @media (min-width: 768px) {
    .navbar-nav .nav-item .nav-link {
      padding-left: 15px;
      padding-right: 15px;
    }
    .navbar-nav .nav-item.dropdown .dropdown-menu {
      position: absolute;
      right: 0;
    }
  }
</style>


    	

    <section class="ftco-gallery">
    	<div class="container-wrap">
    		<div class="row no-gutters">
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url(pic2.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url(pic3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url(pic4.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url(pic5.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section>

<section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(vid4.gif);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
        	<div class="col-md-10">
        		<div class="row">
		          <div class="col-md-3 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-pizza-1"></span></div>
		              	<strong class="number" data-number="2">0</strong>
		              	<span>Pizza Branches</span>
		              </div>
		            </div>
		          </div>
		          
		          <div class="col-md-6 col-lg-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-laugh"></span></div>
		              	<strong class="number" data-number="1264">0</strong>
		              	<span>Happy Customer</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-chef"></span></div>
		              	<strong class="number" data-number="31">0</strong>
		              	<span>Staff</span>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
        </div>
      </div>
    </section>

    

    
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <h2 class="mb-4">Recent from blog</h2>
                <p>We invite you to leave us your review after completing your order. Whether it's the savory flavors, the impeccable presentation, or the prompt delivery, we value your feedback. </p>
            </div>
        </div>
        <div class="row gy-5 gx-4">
            <!-- First Card -->
            <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item d-flex h-100">
                    <div class="service-img">
                        <img class="img-fluid" src="review.jpg" alt="">
                    </div>
                    <div class="service-text p-5 pt-0">
                        <div class="service-icon">
                            <img class="img-fluid rounded-circle" src="user.png" alt="">
                        </div>
                        <h5 class="mb-3">Ms. Mia Joanna Javier</h5>
                        <p class="mb-4">Thank you po, napakasarap po lahat ng flavors.</p>
                        <a class="btn btn-square rounded-circle" href="https://www.facebook.com/photo/?fbid=451611597618466&set=a.114527957993500"><i class="bi bi-chevron-double-right"></i></a>
                        <span class="info-icon ms-3" onclick="toggleMessage('message1')">
                            <i class="bi bi-info-circle-fill text-primary"></i>
                        </span>
                        <div id="message1" class="message" style="display: none; color: white;">
<br>
                            36 Inches Giant Pizza (6 flavors)

✅Cheesy Spinach
<br>
✅La Suprema
<br>
✅Marhaba Shawarma
<br>
✅Aloha Hawaiian
<br>
✅Quad-Cheese
<br>
✅Bacon & Mushroom
                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Card -->
            <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item d-flex h-100">
                    <div class="service-img">
                        <img class="img-fluid" src="kylepiz.jpg" alt="">
                    </div>
                    <div class="service-text p-5 pt-0">
                        <div class="service-icon">
                            <img class="img-fluid rounded-circle" src="prof.jpg" alt="">
                        </div>
                        <h5 class="mb-3">Kyle I love Jana Puno</h5>
                        <p class="mb-4">Sobrang sarap ng pizza na'to nawawala sa isip ko na iniwan na nya ako.</p>
                        <a class="btn btn-square rounded-circle" href="https://www.facebook.com/permalink.php?story_fbid=pfbid0Ss9qrHxGpQdo6eCGgseGj9ZuWoNo8XrDxG2vDBBKkSfsFEaWNUz8QdhsysXRhcEGl&id=100083088889386"><i class="bi bi-chevron-double-right"></i></a>
                        <span class="info-icon ms-3" onclick="toggleMessage('message2')">
                            <i class="bi bi-info-circle-fill text-primary"></i>
                        </span>
                        <div id="message2" class="message" style="display: none; color: white;">
<br>
                          24” 2 flavors
<br>
✅Cheesy Spinach
<br>
✅La Suprema
                        </div>
                    </div>
                </div>
            </div>
            <!-- Third Card -->
            <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item d-flex h-100">
                    <div class="service-img">
                        <img class="img-fluid" src="chic.jpg" alt="">
                    </div>
                    <div class="service-text p-5 pt-0">
                        <div class="service-icon">
                            <img class="img-fluid rounded-circle" src="prof1.jpg" alt="">
                        </div>
                        <h5 class="mb-3">Regina Mei Salunga</h5>
                        <p class="mb-4">The best itong Chic'N'Fries, lagi namin order ng boyfriend ko sobrang sulit.</p>
                        <a class="btn btn-square rounded-circle" href="https://www.facebook.com/photo/?fbid=403180825794877&set=pcb.403183902461236"><i class="bi bi-chevron-double-right"></i></a>
                        <span class="info-icon ms-3" onclick="toggleMessage('message3')">
                            <i class="bi bi-info-circle-fill text-primary"></i>
                        </span>
                        <div id="message3" class="message" style="display: none; color: white;">
<br>
                           Chic'N'Fries 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleMessage(id) {
        var message = document.getElementById(id);
        if (message.style.display === "none") {
            message.style.display = "block";
        } else {
            message.style.display = "none";
        }
    }

   

 // Ensure the collapse functionality works properly
  $(document).ready(function() {
    $('.navbar-toggler').on('click', function() {
      $('#ftco-nav').collapse('toggle');
    });

    $('.nav-link').on('click', function() {
      if ($(window).width() < 768) {
        $('#ftco-nav').collapse('hide');
      }
    });
  });
</script>


  
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="libmlk/wow/wow.min.js"></script>
    <script src="libmlk/easing/easing.min.js"></script>
    <script src="libmlk/waypoints/waypoints.min.js"></script>
    <script src="libmlk/owlcarousel/owl.carousel.min.js"></script>
    <script src="libmlk/counterup/counterup.min.js"></script>
    <script src="libmlk/parallax/parallax.min.js"></script>
    <script src="libmlk/lightbox/jsmlk/lightbox.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Template Javascript -->
    <script src="jsmlk/mainmlk.js"></script>
  </body>
</php>
