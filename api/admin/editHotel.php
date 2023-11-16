<?php
session_start();
require __DIR__ . '/functions.php';



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Edit Hotel</title>
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
        <button type="submit" name="returnAdminHotel" class="tranBack"><img class="homeButtonAdmin mx-3 mt-3"
                src="../../static/img/home1.gif" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-animated-icons/home"></button>
    </form>

    <!-- New User -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">


            <!-- If the button is clicked, the information will be updated and the message will show -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                adminEditHotel();
            }
            ?>

            <!-- Register New User -->
            <div class="container d-flex justify-content-center align-items-center">
                <div class="mt-5 mb-5 mx-5">

                    <form method="POST" name="signUpForm" class="adminView p-5">
                        <h2> Edit the hotel: </h2>

                        <div class="d-flex justify-content-center align-items-center my-4">
                            <table>
                                <!-- Name -->
                                <tr>
                                    <td class="p-4"><label for="editHotelName" class="labelStyle"> Hotel Name: </label>
                                    </td>
                                    <td class="p-4"><input type="text" name="editHotelName" class="inputAdminStyle">
                                    </td>
                                </tr>

                                <!-- Price per night -->
                                <tr>
                                    <td class="p-4"><label for="editHotelPrice" class="labelStyle"> Price Per Night:
                                        </label></td>
                                    <td class="p-4"><input type="number" name="editHotelPrice" class="inputAdminStyle">
                                    </td>
                                </tr>

                                <!-- Features -->
                                <tr>
                                    <td class="p-4"><label for="editHotelFeatures" class="labelStyle"> Features:
                                        </label></td>
                                    <td class="p-4"><input type="text" name="editHotelFeatures" class="inputAdminStyle">
                                    </td>
                                </tr>

                                <!-- Type -->
                                <tr>
                                    <td class="p-4"><label for="editHotelType" class="labelStyle"> Type: </label></td>
                                    <td class="p-4"><select name="editHotelType" class="inputAdminStyle">
                                            <option selected></option>
                                            <option value="Villa Suite">Villa Suite</option>
                                            <option value="Executive suite">Executive suite</option>
                                            <option value="Studio">Studio</option>
                                            <option value="Presidential suite">Presidential suite</option>
                                        </select></td>
                                </tr>

                                <!-- Beds -->
                                <tr>
                                    <td class="p-4"><label for="editHotelBeds" class="labelStyle"> Beds: </label></td>
                                    <td class="p-4"><input type="number" name="editHotelBeds" class="inputAdminStyle">
                                    </td>
                                </tr>

                                <!-- Rating -->
                                <tr>
                                    <td class="p-4"><label for="editHotelRating" class="labelStyle"> Rating: </label>
                                    </td>
                                    <td class="p-4"><input type="number" name="editHotelRating" class="inputAdminStyle">
                                    </td>
                                </tr>

                                <!-- Address -->
                                <tr>
                                    <td class="p-4"><label for="editHotelAddress" class="labelStyle"> Address: </label>
                                    </td>
                                    <td class="p-4"><input type="text" name="editHotelAddress" class="inputAdminStyle">
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <!-- Log In Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3 mb-5">
                                <button name="adminEditHotelFinal" type="submit" class="infoButtons p-2">Edit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
</body>

</html>