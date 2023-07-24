<?php
session_start();
require './functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>The View</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../css/hotels.css'>
</head>

<body>

    <!-- Carousel -->
    <div id="carousel" class="carousel slide mb-5" data-bs-ride="carousel">

        <!-- Indicators on carousel -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">

            <!-- View 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/view1.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Exterior.jpg">
                </picture>
            </div>

            <!-- View 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/view2.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Living-Room.jpg">
                </picture>
            </div>

            <!-- View 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/view3.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Master-Bedroom.jpg">
                </picture>
            </div>

            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>


    <!-- Form Information -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="mt-3 mb-5 mx-5 hotelView p-5">
                    <form method="POST">

                        <!-- Return Home Button -->
                        <form method="POST">
                            <button type="submit" name="returntoHotelPage" class="tranBack"><img
                                    class="homeButton mx-3 mt-3" src="../img/home.png" alt="Back to Home Page"
                                    title="Back to Home Page"
                                    attribution="https://www.flaticon.com/free-icons/home"></button>
                        </form>

                        <h1> Welcome to The View </h1>

                        <p> The View is a tranquil retreat for a relaxing self-catering holiday – only five minutes away
                            of the vibrant Mykonos Town with its unmatched shopping, dining and nightlife. The 4 boho
                            suites that consist The View are located above the charming beach of Agios Stefanos and
                            combine modern architecture with classic Cycladic styling elements, all offering stunning
                            views of the Aegean.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>