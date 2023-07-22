<?php

session_start();
require './functions.php';

// Check if the viewMoreButton is submitted
if (isset($_POST['viewMoreButton'])) {
    // Your message to be displayed
    $message = <<<DELIMITER
    <form method="POST">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="messageView p-3">
                <h6> Kindly Log In or Register to view our Hotels </h6>
                <button type="submit" name="existMessage" class="existMessage"><span class="close p-3">&times;</span></button>
            </div>
        </div>
    </form>
    DELIMITER;
    $displayMessage = true;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Greece Bookings</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../css/home.css'>
</head>

<body>

    <!-- Carousel Video -->
    <div id="carousel" class="carousel slide mb-5" data-bs-ride="carousel">

        <!-- Indicators on carousel -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">

                <video id="oceanView" autoplay loop muted>
                    <source src="../video/background-ocean.mp4" type="video/mp4"
                        attribution="Video by Dimitris Mourousiadis: https://www.pexels.com/video/aerial-view-of-beautiful-greek-beach-6460125/">
                </video>

                <div class="carousel-caption">
                    <h1> Greece Bookings </h1>
                    <h4> Book your Hotel, Compare it to others and explore the magnificent Greece! </h4>
                </div>
            </div>

            <div class="carousel-item">

                <video id="oceanView" autoplay loop muted>
                    <source src="../video/background-greece.mp4" type="video/mp4"
                        attribution="Video by Pat Whelen: https://www.pexels.com/video/acropolis-of-athens-5737310/">
                </video>

                <div class="carousel-caption">
                    <h1> Greece Bookings </h1>
                    <h4> Book your Hotel, Compare it to others and explore the magnificent Greece! </h4>
                </div>
            </div>

            <div class="carousel-item">

                <video id="oceanView" autoplay loop muted>
                    <source src="../video/background-houses.mp4" type="video/mp4"
                        attribution="Video by Dimitris Mourousiadis: https://www.pexels.com/video/aerial-shot-of-santorini-6192496/">
                </video>

                <div class="carousel-caption">
                    <h1> Greece Bookings </h1>
                    <h4> Book your Hotel, Compare it to others and explore the magnificent Greece! </h4>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- This is where the message will show if the user clicked on 'View More' -->
    <span id="loginFormId"> </span>
    <?php if (isset($displayMessage) && $displayMessage): ?>
        <span id="loginFormId">
            <?php echo $message; ?>
        </span>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Existing Log In -->
            <div class="col-sm-6">
                <div class="mt-5 mb-5 mx-5 loginForm p-5">

                    <form method="POST">
                        <h2> Kindly log in to your profile: </h2>

                        <!-- Username -->
                        <table>
                            <tr>
                                <td class="p-4"><label for="username" class="labelStyle"> Username: </label></td>
                                <td class="p-4"><input type="text" name="username" class="inputStyle" required></td>
                            </tr>

                            <!-- Password -->
                            <tr>
                                <td class="p-4"><label for="password" class="labelStyle"> Password: </label></td>
                                <td class="p-4"><input type="password" name="password" class="inputStyle" required></td>
                            </tr>

                            <!-- Email -->
                            <tr>
                                <td class="p-4"><label for="email" class="labelStyle"> Email: </label></td>
                                <td class="p-4"><input type="email" name="email" class="inputStyle" required></td>
                            </tr>
                        </table>

                        <!-- Log In Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3 mb-5">
                                <button name="logInButton" type="submit" class="logInButton p-2">Log In</button>
                            </div>
                        </div>

                    </form>

                    <!-- Directs to New User Sign Up -->
                    <form method="POST">

                        <h2> Are you a new user? </h2>

                        <!-- New User Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3">
                                <button name="existButton" type="submit" class="logInButton p-2">Sign Up</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Staff Form Section -->
            <div class="col-sm-6">
                <div class="mt-5 mb-5 mx-5 loginForm p-5">
                    <form method="POST">

                        <h2> Are you a staff member? </h2>

                        <!-- Staff Id -->
                        <table>
                            <tr>
                                <td class="p-4"><label for="id" class="labelStyle"> Staff Id: </label></td>
                                <td class="p-4"><input type="text" name="id" class="inputStyle" required></td>
                            </tr>
                        </table>

                        <!-- Log in Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3">
                                <button name="existButton" type="submit" class="logInButton p-2">Log In</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Hotles -->
    <form method="POST">
        <div class="container-fluid">

            <div class="d-flex justify-content-center align-items-center">
                <div class="background mx-5 my-4 p-3">
                    <h3> What we have to offer </h3>
                </div>
            </div>

            <div class="row">

                <!-- Marbella Elix -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../img/marbellaElix.jpg" alt="Card image">

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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Royal Senses -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../img/royalSenses.jpg" alt="Card image">

                            <div class="card-img-overlay">
                                <h5 class="card-title p-2"> Royal Sensesx </h5>
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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
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
                            <img class="card-img-top hotelImage" src="../img/theView.jpg" alt="Card image">

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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Angsana Corfu -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../img/angsanaCorfu.jpg" alt="Card image">

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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Rooster -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../img/theRooster.jpg" alt="Card image">

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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Destino Pacha -->
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../img/destinoPacha.jpeg" alt="Card image">

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
                                    <button type="submit" name="viewMoreButton" class="viewMoreButton p-2"> View More
                                    </button>
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