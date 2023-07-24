<?php
session_start();
require './functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Destino Pacha</title>
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
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="5"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="6"></button>
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">

            <!-- Destino 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino1.jpeg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/04/destino-pacha6.jpeg">
                </picture>
            </div>

            <!-- Destino 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino2.jpeg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/04/destino-pacha2.jpeg">
                </picture>
            </div>

            <!-- Destino 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino3.jpeg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/04/destino-pacha7.jpeg">
                </picture>
            </div>

            <!-- Destino 4 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino4.jpg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://cf.bstatic.com/xdata/images/hotel/max1024x768/310534652.jpg?k=717880fda40f503e21bd3cc76ba6c302c16c8d5a15dc10e7e46abae012d12ddd&o=&hp=1">
                </picture>
            </div>

            <!-- Destino 5 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino5.jpg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://www.nichetravelguides.com/wp-content/uploads/2020/12/Oniro-1.jpg">
                </picture>
            </div>

            <!-- Destino 6 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino6.jpg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://cf.bstatic.com/xdata/images/hotel/max1024x768/310534660.jpg?k=2946da1c3163a1e103cc5e5a6928c93566d8521c2b43aada0d22e09e8a4c2cc5&o=&hp=1">
                </picture>
            </div>

            <!-- Destino 7 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../img/destino7.jpg" alt="Destino Pacha" class="destinoImage"
                        attribution="https://cf.bstatic.com/xdata/images/hotel/max1024x768/343096454.jpg?k=cf75813e6c18bcbc5375c0bceac14697e2b62194f3095d1efb02027697a267c2&o=&hp=1">
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

                        <h1> Welcome to Destino Pacha </h1>

                        <p> Destino Pacha Mykonos is located in one of the most beautiful parts of the island,
                            overlooking the turquoise waters of the Aegean. It offers 34 rooms, with six spacious suites
                            and combines traditional Cycladic architecture with modern touches, typical of the Pacha
                            group. The elegant floors and the prevailing white are complemented by natural wood, stone
                            and linen fabrics.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>