<?php
session_start();
require __DIR__ . '/functions.php';



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Edit Booking</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/staff.css'>
</head>

<body>

    <!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="returnAdminBooking" class="tranBack"><img class="homeButtonAdmin mx-3 mt-3"
                src="../../static/img/home1.gif" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-animated-icons/home"></button>
    </form>

    <!-- New User -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">


            <!-- If the button is clicked, the information will be updated and the message will show -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                adminEditBooking();
            }
            ?>

            <!-- Register New User -->
            <div class="container d-flex justify-content-center align-items-center">
                <div class="mt-5 mb-5 mx-5">

                    <form method="POST" name="signUpForm" class="adminView p-5">
                        <h2> Edit the booking: </h2>

                        <div class="d-flex justify-content-center align-items-center my-4">
                            <table>

                                <!-- CheckInDate -->
                                <tr>
                                    <td class="p-4"><label for="editCheckInDate" class="labelStyle"> Edit Check In Date:
                                        </label></td>
                                    <td class="p-4"><input type="date" name="editCheckInDate" class="inputAdminStyle">
                                    </td>
                                </tr>

                               <!-- CheckOutDate -->
                               <tr>
                                    <td class="p-4"><label for="editCheckOutDate" class="labelStyle"> Edit Check Out Date:
                                        </label></td>
                                    <td class="p-4"><input type="date" name="editCheckOutDate" class="inputAdminStyle">
                                    </td>
                                </tr>


                            </table>
                        </div>

                        <!-- Log In Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3 mb-5">
                                <button name="adminEditBookingFinal" type="submit" class="infoButtons p-2">Edit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
</body>

</html>