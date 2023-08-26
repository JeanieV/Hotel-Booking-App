<?php
session_start();
require '../functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Confirm Booking </title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/bookings.css'>
</head>

<body>

    <!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="returntoHotelPage" class="tranBack"><img class="homeButton mx-3 mt-3"
                src="../../static/img/home.png" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-icons/home"></button>
    </form>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">

            <form method="POST" class="bookView p-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="mt-5 mb-5 mx-5">
                        <?php
                        if (isset($_SESSION['user_id']) && isset($_SESSION['hotel_id'])) {
                            $userId = $_SESSION['user_id'];
                            $hotelId = $_SESSION['hotel_id'];
                            confirmBooking($userId, $hotelId);
                        }

                        ?>
                        <?php confirmFinalBooking(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>