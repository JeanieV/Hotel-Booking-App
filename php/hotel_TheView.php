<?php
session_start();
require './functions.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

// Immediately storing the hotel_id in a session variable
if (isset($_GET['hotel_id'])) {
    $hotelId = $_GET['hotel_id'];
    $_SESSION['hotel_id'] = $hotelId;
}

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

            <!-- View 1 -->
            <div class="carousel-item active d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view1.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Exterior.jpg">
                </picture>
            </div>

            <!-- View 2 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view2.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Living-Room.jpg">
                </picture>
            </div>

            <!-- View 3 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view3.jpg" alt="The View" class="viewImage"
                        attribution="https://www.thehoteltrotter.com/wp-content/uploads/2021/02/AriaHotels_TheView_Master-Bedroom.jpg">
                </picture>
            </div>

            <!-- View 4 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view4.jpg" alt="The View" class="viewImage"
                        attribution="https://www.discovergreece.com/sites/default/files/styles/default/public/2019-12/basilicas_of_saint_stephen_in_kos-edited-1.jpg?itok=-CBg8mZL">
                </picture>
            </div>

            <!-- View 5 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view5.webp" alt="The View" class="viewImage"
                        attribution="https://images.trvl-media.com/lodging/4000000/3680000/3673200/3673167/e4d700fc.jpg?impolicy=resizecrop&rw=1200&ra=fit">
                </picture>
            </div>

            <!-- View 6 -->
            <div class="carousel-item d-flex justify-content-center align-items-center">
                <picture>
                    <img src="../static/img/view6.avif" alt="The View" class="viewImage"
                        attribution="https://images.trvl-media.com/lodging/4000000/3680000/3673200/3673167/3f996764.jpg?impolicy=resizecrop&rw=1200&ra=fit">
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

                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        addTemporaryBooking();
                    }
                    ?>

                    <form method="POST">

                        <!-- Return Home Button -->
                        <button type="submit" name="returntoHotelPage" class="tranBack"><img
                                class="homeButton mx-3 mt-1 mb-2" src="../static/img/home.png" alt="Back to Home Page"
                                title="Back to Home Page"
                                attribution="https://www.flaticon.com/free-icons/home"></button>


                        <?php echo "<h1 class='mb-5'> Welcome to The View, $username! </h1>" ?>

                        <p class="p-2 my-4"> The View is a tranquil retreat for a relaxing self-catering holiday –
                            only
                            five minutes away
                            of the vibrant Mykonos Town with its unmatched shopping, dining and nightlife. The View
                            are
                            located above the charming beach of Agios Stefanos and
                            combine modern architecture with classic Cycladic styling elements, all offering
                            stunning
                            views of the Aegean.</p>

                        <!-- Date Output -->
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

                        <?php
                        // Display error message if set
                        if (isset($_SESSION['dateMessage'])) {
                            echo '<div class="container d-flex justify-content-center align-items-center">';
                            echo '<p class="text-danger">' . $_SESSION['dateMessage'] . '</p>';
                            echo '</div>';
                            unset($_SESSION['dateMessage']);
                        }
                        ?>

                        <?php showInformation(); ?>

                        <div class="d-flex justify-content-center align-items-center">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                            <input type="hidden" name="hotel_id" value="<?php echo $_SESSION['hotel_id'] ?>">
                            <button type="submit" name="bookButton" class="extraInfoButtons p-2 mt-5 mb-2"> Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php echo "<h4 class='mb-5'> $username, compare your hotel with another! </h4>" ?>

        <div class="d-flex justify-content-center align-items-center">

            <div class="infoBackground p-3 mb-4 d-flex justify-content-center align-items-center">
                <table>
                    <tr>
                        <td>
                            <img src="../static/img/expensive.png" class="small-image" alt="Hotel image"
                                attribution="https://www.flaticon.com/free-icons/expensive">
                        </td>
                        <td>
                            <p> More Expensive </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="../static/img/best-price.png" class="small-image" alt="Hotel image"
                                attribution="https://www.flaticon.com/free-icons/best-price">
                        </td>
                        <td>
                            <p> Cheaper</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="../static/img/best-rating.png" class="small-image" alt="Hotel image"
                                attribution="https://www.flaticon.com/free-icons/expertise">
                        </td>
                        <td>
                            <p> Better Rating</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="../static/img/bad-rating.png" class="small-image" alt="Hotel image"
                                attribution="https://www.flaticon.com/free-icons/thumbs-down">
                        </td>
                        <td>
                            <p> Poorer Rating</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php cardComparedHotels(); ?>

    </div>

</body>

</html>