<?php
include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<body>
  <?php include('../include/nav.php'); ?>

  <div class="carousel">
    <!-- list item -->
    <div class="list">
      <div class="item">
        <img src="../assets/catering.jpg">
        <div class="content">
          <div class="author" style="font-size: 24px; color: #ff5900;">LA FARINA</div>
          <div class="topic" style="font-size: 50px;">CATERING SERVICE</div>

          <div class="des">
            <!-- lorem 50 -->
          </div>

          <div class="buttons">
            <button onclick="scrollToBookUs()">BOOK NOW</button>
          </div>
          <script>
            function scrollToBookUs() {
              var element = document.querySelector('.contact');
              element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          </script>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering2.jpg">
        <div class="content">
          <div class="author" style="font-size: 24px; color: #ff5900;">LA FARINA</div>
          <div class="topic" style="font-size: 50px;">CATERING SERVICE</div>

          <div class="des">
            <!-- lorem 50 -->
          </div>
          <div class="buttons">
            <button onclick="scrollToBookUs()">BOOK NOW</button>
          </div>
          <script>
            function scrollToBookUs() {
              var element = document.querySelector('.contact');
              element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          </script>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering3.jpg">
        <div class="content">
          <div class="author" style="font-size: 24px; color: #ff5900;">LA FARINA</div>
          <div class="topic" style="font-size: 50px;">CATERING SERVICE</div>

          <div class="des">
            <!-- lorem 50 -->
          </div>
          <div class="buttons">
            <button onclick="scrollToBookUs()">BOOK NOW</button>
          </div>
          <script>
            function scrollToBookUs() {
              var element = document.querySelector('.contact');
              element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          </script>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering4.jpg">
        <div class="content">
          <div class="author" style="font-size: 24px; color: #ff5900;">LA FARINA</div>
          <div class="topic" style="font-size: 50px;">CATERING SERVICE</div>

          <div class="des">
            <!-- lorem 50 -->
          </div>
          <div class="buttons">
            <button onclick="scrollToBookUs()">BOOK NOW</button>
          </div>
          <script>
            function scrollToBookUs() {
              var element = document.querySelector('.contact');
              element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          </script>
        </div>
      </div>
    </div>

    <!-- list thumbnail -->
    <div class="thumbnail">
      <div class="item">
        <img src="../assets/catering.jpg">
        <div class="content">
          <div class="title"></div>
          <div class="description"></div>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering2.jpg">
        <div class="content">
          <div class="title"></div>
          <div class="description"></div>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering3.jpg">
        <div class="content">
          <div class="title"></div>
          <div class="description"></div>
        </div>
      </div>
      <div class="item">
        <img src="../assets/catering4.jpg">
        <div class="content">
          <div class="title"></div>
          <div class="description"></div>
        </div>
      </div>
    </div>

    <!-- next prev -->
    <div class="arrows">
      <button id="prev">&lt;</button>
      <button id="next">&gt;</button>
    </div>
  </div>

  <script src="../appzzzzz.js"></script>

  <style>
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      background-color: #333;
      padding: 10px 20px;
    }

    .navbar-brand {
      font-size: 24px;
      color: #fff;
    }

    .navbar-nav {
      margin-left: auto;
    }

    .navbar-nav .nav-item {
      margin-right: 15px;
    }

    .navbar-nav .nav-link {
      color: #fff;
    }

    .navbar-nav .nav-link:hover {
      color: #ccc;
    }

    .carousel {
      margin-top: 70px;
    }
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

  <style>
    .form-control,
    .form-select {
      color: black !important;
      background-color: white !important;
    }

    .form-control::placeholder,
    .form-select::placeholder {
      color: #6c757d !important;
    }

    /* Popup modal styles */
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      padding: 20px;
      text-align: center;
      z-index: 1000;
      border-radius: 10px;
    }

    .popup.open-popup {
      display: block;
    }

    .popup i {
      font-size: 50px;
      color: green;
    }

    .popup h2 {
      margin: 20px 0 10px;
    }

    .popup p {
      margin-bottom: 20px;
    }
  </style>

  <script>
    function validateForm(event) {
      event.preventDefault();
      const contactNumber = document.querySelector('input[type="mobile"]').value;
      const email = document.querySelector('input[type="email"]').value;
      const date = document.querySelector('input[type="date"]').value;

      if (isNaN(contactNumber) || contactNumber.trim() === "") {
        alert("Please enter a valid contact number.");
        return false;
      }

      if (!contactNumber || !email || !date) {
        alert("Please fill out all fields.");
        return false;
      }

      openPopup();
      return true;
    }

    function openPopup() {
      document.getElementById("popup").classList.add("open-popup");
    }

    function closePopup() {
      document.getElementById("popup").classList.remove("open-popup");
    }
  </script>
</head>

<body>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .form-control {
      color: black;
    }
  </style>

</head>

<body>

  <!-- Your HTML code -->
  <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row g-0">
        <div class="col-1">
          <img src="../img/background-site.jpg" class="img-fluid h-100 w-100 rounded-start" style="object-fit: cover; opacity: 0.7;" alt="">
        </div>
        <div class="col-10">
          <div class="border-bottom border-top border-primary bg-light py-5 px-4">
            <div class="text-center">
              <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Book Us</small>
              <h1 class="display-5 mb-5">Where you want Our Services</h1>
            </div>
            <form>
                <div class="row g-4 form">
                    <div class="col-lg-4 col-md-6">
                        <input type="text" class="form-control border-primary p-2" name="streetName" placeholder="Enter Street Name" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="text" class="form-control border-primary p-2" name="municipality" placeholder="Enter Municipality" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="text" class="form-control border-primary p-2" name="city" placeholder="Enter City" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="text" class="form-control border-primary p-2" name="eventType" placeholder="Enter Event Type" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="number" class="form-control border-primary p-2" name="numberOfPeople" placeholder="Enter Number of People" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control border-primary p-2" name="foodPreference" placeholder="Enter Food Preference" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="tel" class="form-control border-primary p-2" name="contactNumber" placeholder="Your Contact No." required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="date" class="form-control border-primary p-2" name="date" placeholder="Select Date" required>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <input type="email" class="form-control border-primary p-2" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill">Submit Now</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="col-1">
          <img src="../img/background-site.jpg" class="img-fluid h-100 w-100 rounded-end" style="object-fit: cover; opacity: 0.7;" alt="">
        </div>
      </div>
    </div>
  </div>

  <!-- Popup Modal -->
  <div class="popup" id="popup">
    <i class="fa-solid fa-check"></i>
    <div class="content">
      <h2>Submitted Successfully</h2>
      <p>Thank you for booking us!</p>
      <button onclick="closePopup()">OK</button>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
  <!-- Your custom script -->
  <script>
    // Enable Bootstrap popover
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl)
    })
  </script>

  <section class="recipe_section layout_padding-top">
    <div class="container">
      <div class="heading_container heading_center">
        <h2 style="color: white;">
          Our Food Selection
        </h2>
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="../piz12.gif" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4 style="color: white;">
                Pizza
              </h4>
              <a href="menu1.html">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="../wings12.gif" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4 style="color: white;">
                Wings
              </h4>
              <a href="menu1.html">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="../tea.gif" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4 style="color: white;">
                Milk Tea
              </h4>
              <a href="menu1.html">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href="">
          Order Now
        </a>
      </div>
    </div>
  </section>

  <br>
  <br>

  <footer class="ftco-footer ftco-section img">
    <div class="overlay"></div>
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">About Us</h2>
            <p>La Farina prides itself on its diverse menu, showcasing an enticing array of culinary delights. From tender chicken and flavorful pasta to crispy fries and indulgent milk tea, their offerings cater to a wide range of tastes.</p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
              <li class="ftco-animate"><a href="https://www.facebook.com/profile.php?id=100083088889386"><span class="icon-facebook"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Recent Blog</h2>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(review.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="https://www.facebook.com/photo/?fbid=451611597618466&set=a.114527957993500">Thank you po, napakasarap po lahat ng flavors.</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> June 2, 2024</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 0</a></div>
                </div>
              </div>
            </div>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(feed.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="https://www.facebook.com/photo/?fbid=407798545333105&set=a.114527947993501">Sulit na sulit po yung 36</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> March 23, 2024</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 0</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 mb-5 mb-md-5">
          <div class="ftco-footer-widget mb-4 ml-md-4">
            <h2 class="ftco-heading-2">Services</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">Catering</a></li>
              <li><a href="#" class="py-2 d-block">Delivery</a></li>
              <li><a href="slider.html" class="py-2 d-block">Quality Foods</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text">Maningning Street 1st floor, NONO’s Commercial Building, Santo Domingo 2021 Mexico, Philippines</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">0905 260 0388</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">lafarina112022@gmail.com</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg>
  </div>
  <?php include('../include/foot.php'); ?>
  <script>
    $(document).ready(function() {
      $("form").on("submit", function(event) {
          event.preventDefault(); // Prevent the default form submission
          
          // Create FormData object from the form
          const formData = new FormData(this);
          
          // AJAX request using FormData
          $.ajax({
              url: "../controller/services.php?action=booking",
              type: "POST",
              data: formData,
              contentType: false, // Required for FormData
              processData: false, // Prevent jQuery from processing the data
              success: function(response) {
                  const result = JSON.parse(response);
                  if (result.success) {
                      openPopup(); // Show success popup
                      $("form")[0].reset(); // Clear form
                  } else {
                      alert("Error: " + result.message);
                  }
              },
              error: function(xhr, status, error) {
                  console.error("Error:", error);
                  alert("There was an error submitting your booking.");
              }
          });
      });
  });

  // Popup functions
  function openPopup() {
      document.getElementById("popup").classList.add("open-popup");
  }

  function closePopup() {
      document.getElementById("popup").classList.remove("open-popup");
  }
  </script>
</body>
