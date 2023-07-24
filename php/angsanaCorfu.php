<?php
session_start();
require './functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Angsana Corfu</title>
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
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="4"></button>
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">

            <!-- Angsana 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/angsana1.jpg" alt="Angsana Corfu" class="angsanaImage"
                        attribution="https://www.thehoteltrotter.com/angsana-corfu-europes-first-and-much-anticipated-banyan-tree-resort/">
                </picture>
            </div>

            <!-- Angsana 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/angsana2.jpg" alt="Angsana Corfu" class="angsanaImage" 
                        attribution="https://www.thehoteltrotter.com/angsana-corfu-europes-first-and-much-anticipated-banyan-tree-resort/">
                </picture>
            </div>

            <!-- Angsana 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/angsana3.jpg" alt="Angsana Corfu" class="angsanaImage"
                        attribution="https://www.thehoteltrotter.com/angsana-corfu-europes-first-and-much-anticipated-banyan-tree-resort/">
                </picture>
            </div>

            <!-- Angsana 4 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/angsana4.jpg" alt="Angsana Corfu" class="angsanaImage"
                        attribution="https://www.thehoteltrotter.com/angsana-corfu-europes-first-and-much-anticipated-banyan-tree-resort/">
                </picture>
            </div>

            <!-- Angsana 5 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/angsana5.jpg" alt="Angsana Corfu" class="angsanaImage"
                        attribution="https://www.thehoteltrotter.com/angsana-corfu-europes-first-and-much-anticipated-banyan-tree-resort/">
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

                        <h1> Welcome to Angsana Corfu </h1>

                        <p> Set on an idyllic lush green hilltop overlooking the turquoise waters of the historical
                            Benitses Bay, lies Angsana Corfu –Banyan Tree’s first and much-anticipated resort in Europe.
                            It identifies as a Mediterranean sanctuary of extraordinary beauty, a luxurious spa and
                            beach resort offering a unique blend of Greek and Asian hospitality.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>