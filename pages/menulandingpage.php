<?php
include('../include/db_connect.php');
include('../include/head.php');
// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user_id is stored in session when logged in
?>

<style>
    #prev, #next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: darkorange; /* Change to dark yellow or orange */
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 2em;
        z-index: 1000;
    }

    #prev {
        left: 10px;
    }

    #next {
        right: 10px;
    }
</style>

<body>
    <?php include('../include/nav.php'); ?>

    <div class="slider">
        <div class="title">
            Our Pizza!
        </div>
        <div class="images">
            <div class="item" style="--i: 1">
                <img src="../assets/piz1.PNG">
            </div>
            <div class="item" style="--i: 2">
                <img src="../assets/piz2.PNG">
            </div>
            <div class="item" style="--i: 3">
                <img src="../assets/piz3.PNG">
            </div>
            <div class="item" style="--i: 4">
                <img src="../assets/piz4.PNG">
            </div>
            <div class="item" style="--i: 5">
                <img src="../assets/piz5.PNG">
            </div>
            <div class="item" style="--i: 6">
                <img src="../assets/piz6.PNG">
            </div>
        </div>
        
        <button id="prev">&lt;</button>
        <button id="next">&gt;</button>
    </div>

    <section class="recipe_section layout_padding-top">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Our Food Selection</h2>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 mx-auto">
                    <div class="box">
                        <div class="img-box">
                            <img src="../piz12.gif" class="box-img" alt="">
                        </div>
                        <div class="detail-box">
                            <h4>Pizza</h4>
                            <a href="../assets/menumain.php">
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
                            <h4>Wings</h4>
                            <a href="../assets/menumain.php">
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
                            <h4>Milk Tea</h4>
                            <a href="../assets/menumain.php">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-box">
                <a href="menumain.php">View Full Menu</a>
            </div>
        </div>
    </section>

    <br>

    <script src="../app.js"></script>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

    <script>
        function toggleMessage(id) {
            var message = document.getElementById(id);
            if (message.style.display === "none") {
                message.style.display = "block";
            } else {
                message.style.display = "none";
            }
        }
    </script>

<?php include('../include/foot.php'); ?>
