<?php
session_start();
require './functions.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Royal Senses</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../static/css/hotels.css'>
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
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">

            <!-- Royal 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal1.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
                </picture>
            </div>

            <!-- Royal 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal2.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
                </picture>
            </div>

            <!-- Royal 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal3.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
                </picture>
            </div>

            <!-- Royal 4 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal4.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
                </picture>
            </div>

            <!-- Royal 5 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal5.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
                </picture>
            </div>

            <!-- Royal 6 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/royal6.jpg" alt="Royal Senses" class="royalImage"
                        attribution="https://www.thehoteltrotter.com/the-royal-senses-resort-crete-welcomes-its-first-hilton-hotel/">
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
                        <button type="submit" name="returntoHotelPage" class="tranBack"><img
                                class="homeButton mx-3 mt-3 mb-4" src="../static/img/home.png" alt="Back to Home Page"
                                title="Back to Home Page"
                                attribution="https://www.flaticon.com/free-icons/home"></button>

                                <?php echo "<h1 class='mb-5'> Welcome to Royal Senses, $username! </h1>" ?>

                        <p> The hotel will be located in the picturesque Rethymno region on the northern part of the
                            island, which has the best weather and attractions that Crete has to offer, including the
                            Melidoni Cave and Knossos Palace. A perfect natural haven for families or friends who want
                            to celebrate togetherness, the hotel balances this joyful feeling with quiet relaxation and
                            the use of ample calm spots that include private beaches and pools, as well as spacious
                            hotel rooms.</p>

                        <!-- Date Output -->
                        <div class="my-3">
                            <?php displayDate(); ?>
                        </div>

                        <?php showInformation(); ?>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" name="bookButton" class="extraInfoButtons p-2 my-5"> Book </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>