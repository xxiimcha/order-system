<?php
include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .spin-image {
        animation: spin 5s linear infinite;
    }

    .hero-header {
        background-image: url('../assets/bg2.jpg');
        background-size: cover; /* This makes sure the background covers the entire div */
        background-position: center;
        background-repeat: no-repeat;
        width: 100%; /* Ensures the hero header takes up full width */
    }

    .container-xxl {
        width: 100%; /* Ensures the container takes up full width */
        padding: 0;
        margin: 0;
    }
</style>

<body>
  <?php include('../include/nav.php');?>
    <!-- Your hero section with spinning image -->
    <div class="container-xxl py-5 hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Customize Your Own Pizza</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">Unleash your inner chef and embark on a culinary adventure like no other with our 'Customize Your Own Pizza' option. Picture this: you're the mastermind behind every delectable detail, from the crust to the toppings and everything in between.</p>
                    <a href="pizzacus.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Customize</a>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid spin-image" src="../assets/izz.png" alt="">
                </div>
            </div>
        </div>
    </div>
<?php include('../include/foot.php');?>
</body>
</html>

