<?php
session_start();
require './functions.php';

if (isset($_SESSION['fullname'])) {
    $fullname = $_SESSION['fullname'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Hotel Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../static/css/home.css'>
</head>

<body>

    <!-- Our Hotles -->
    <form method="POST" action="hotel.php">
        <div class="container-fluid">

            <!-- Return Home Button -->
            <form method="POST">
                <button type="submit" name="logOutButton" class="tranBack"><img class="logOutStyle mt-3"
                        src="../static/img/logout.png" alt="Log Out" title="Log Out"
                        attribution="https://www.flaticon.com/free-icons/logout"></button>
            </form>

            <!-- Buttons -->
            <div class="d-flex justify-content-center align-items-center">
                <form method="POST">
                    <button type="submit" name="bookingsButton" class="extraInfoButtons p-2 mx-3"> Bookings</button>
                    <button type="submit" name="editProfileButton" class="extraInfoButtons p-2 mx-3"> Edit Profile</button>
                </form>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <div class="background mx-5 my-4 p-3">
                    <?php echo "<h3> Greetings, $fullname! </h3>"; ?>
                    <p> View our gorgeous hotels: </p>
                </div>
            </div>

            <div class="row">

                <!-- Marbella Elix -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/marbellaElix.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> Marbella Elix </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="marbellaElix.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="1">
                                        <button type="submit" name="marbellaElixButton" class="viewMoreButton p-2"> View
                                            More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Royal Senses -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/royalSenses.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> Royal Senses </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="royalSenses.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="2">
                                        <button type="submit" name="royalSensesButton" class="viewMoreButton p-2"> View
                                            More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- The View -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/theView.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> The View </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="theView.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="3">
                                        <button type="submit" name="theViewButton" class="viewMoreButton p-2"> View More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Angsana Corfu -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/angsanaCorfu.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> Angsana Corfu </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="angsanaCorfu.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="4">
                                        <button type="submit" name="angsanaButton" class="viewMoreButton p-2"> View More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Rooster -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/theRooster.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> The Rooster </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="theRooster.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="5">
                                        <button type="submit" name="theRoosterButton" class="viewMoreButton p-2"> View
                                            More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Destino Pacha -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../static/img/destinoPacha.jpeg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> Destino Pacha </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="starRating p-2">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="destinoPacha.php" method="GET">
                                        <input type="hidden" name="hotel_id" value="6">
                                        <button type="submit" name="destinoButton" class="viewMoreButton p-2"> View More
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>