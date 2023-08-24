<?php
session_start();
require '../functions.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Staff View User Information</title>
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


    <form method="GET" action="./staff_ViewUsers.php">
        <input id="search" name="search" type="text" placeholder="Type here">
        <input id="submit" type="submit" value="Search">
    </form>

    <!-- Sort Users Alphabetically -->
    <div class="d-flex justify-content-center align-items-center my-5">
        <form method="POST" action="./staff_ViewUser.php">
            <h1> Sort by: </h1>
            <div class="d-flex justify-content-center align-items-center my-5">
                <button type="submit" name="sortUsersA-Username" class="sort p-3 mx-3 mb-2"> Username </button>
                <button type="submit" name="sortUsersA-Number" class="sort p-3 mx-3 mb-2"> Phone Number </button>
            </div>
        </form>
    </div>

    <!-- All the current information of the user will show -->
    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="staffView p-5">
            <?php staffViewUsers(); ?>
        </div>
    </div>



</body>

</html>