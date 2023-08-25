<?php
session_start();
require '../functions.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Staff View Hotel Information</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/staff.css'>
</head>

<body>

    <form method="POST">
        <!-- Return Home Button -->
        <button type="submit" name="returnStaffHome" class="home p-3 mx-3 mt-3"> Staff Page </button>
    </form>


    <!-- Sort Users Alphabetically by -->
    <div class="d-flex justify-content-center align-items-center">
        <form method="POST" action="viewHotel.php">
            
            <div class="d-flex justify-content-center align-items-center mt-4">
                <select name="sortUsers" class="sort-dropdown p-4 mx-3">
                    <option> Sort by: </option>
                    <option value="sortUsersA-name">Hotel name</option>
                    <option value="sortUsersA-priceA">Least price per night</option>
                    <option value="sortUsersA-priceD">Most price per night</option>
                    <option value="sortUsersA-rating">Higher rating</option>
                    <option value="sortUsersA-ratingPoor">Poor rating</option>
                </select>
                <button type="submit" name="sortHotelButton" class="sort-submit p-4">Sort</button>
            </div>

            <!-- Search Bar -->
            <div class="d-flex justify-content-center align-items-center mt-4">
                <input type="text" placeholder="Search all columns" name="search" class="inputStyle">
                <button type="submit" class="glass mx-3 p-2"><i class="fa fa-search"></i></button>

            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <button type="submit" name="clearFilterButton" class="clear-filter-button"><i class="fa fa-times"></i>
                    Clear Filter</button>
            </div>

        </form>
    </div>

    <!-- Search bar -->
    <div class="d-flex justify-content-center align-items-center">
        <form method="POST" action="viewHotel.php">

        </form>
    </div>

    <!-- All the current information of the user will show -->
    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="staffViewH p-3">
            <?php staffViewHotels(); ?>
        </div>
    </div>



</body>

</html>