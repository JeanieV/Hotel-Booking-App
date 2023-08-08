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
    <title>Marbella Elix</title>
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

            <!-- Marbella 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella4.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2020/11/marbellaelix2.jpg">
                </picture>
            </div>

            <!-- Marbella 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella2.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2020/11/marbellaelix19-0357.jpg">
                </picture>
            </div>

            <!-- Marbella 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella3.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2020/11/marbella-elix-4.jpg">
                </picture>
            </div>

            <!-- Marbella 4 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella1.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2020/11/Greece-Hotel-Openings-2021-MarBella-Elix-17.jpg">
                </picture>
            </div>

            <!-- Marbella 5 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella5.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2020/11/marbellaelix20-2037.jpg">
                </picture>
            </div>

            <!-- Marbella 6 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/marbella6.jpg" alt="Marbella Elix"
                        attribution="https://www.thehoteltrotter.com/greece-hotel-openings-2021-marbella-elix/">
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
                                class="homeButton mx-3 mt-3" src="../static/img/home.png" alt="Back to Home Page"
                                title="Back to Home Page"
                                attribution="https://www.flaticon.com/free-icons/home"></button>

                        <?php echo "<h1 class='mb-5'> Welcome to Marbella Elix, $username! </h1>" ?>

                        <p> Located above the beautiful Karavostasi Beach in the Parga region, looking west towards
                            Corfu and Paxos. As the third hotel to join the Marbella Collection portfolio and the
                            brand’s first property outside of the island of Corfu, Marbella Elix sits in unspoilt
                            surroundings where the mountains meet the Ionian Sea. The existing seaside hotel of the
                            place was renovated and turned into a modern resort with t146 spacious and contemporary
                            guest rooms and suites, all featuring stunning views of this beautiful golden coastline.</p>

                        <!-- Check In & Out -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <table>
                                <tr>
                                    <td class="p-4"><label for="checkIn" class="labelStyle"> Check-In Date: </label>
                                    </td>
                                    <td class="p-4"><input type="date" name="checkIn" class="inputStyle"></td>
                                </tr>
                                <tr>
                                    <td class="p-4"><label for="checkOut" class="labelStyle"> Check-Out Date:
                                        </label>
                                    </td>
                                    <td class="p-4"><input type="date" name="checkOut" class="inputStyle"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="container d-flex justify-content-center align-items-center">
                            <button type="submit" name="dateConfirmHotelPage" class="dateConfirmHotelPage p-2 my-3">
                                Confirm Date </button>
                        </div>
                        <!-- Date Output -->
                        <div class="my-3">
                            <?php displayDate(); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>