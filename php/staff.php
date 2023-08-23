<?php
session_start();
require './functions.php';

if (isset($_SESSION['staffFullName'])) {
    $staffFullName = $_SESSION['staffFullName'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Staff</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../static/css/staff.css'>
</head>

<body>

    <form method="POST">
        <!-- Return Home Button -->
        <button type="submit" name="returnHome" class="home p-3 mx-3 my-3"> Home</button>
    </form>

    <?php echo "<h1> Greetings, $staffFullName! </h1>"; ?>

    <div class="d-flex justify-content-center align-items-center my-5">

        

        <div class="row">

            <!-- Button which will get the userId -->
            <div class="col-sm-6">

                <form method="GET" action="viewUserInfo.php">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    <button name="viewInfo" type="submit" class="infoButtons p-3">Users </button>
                </form>
            </div>

            <!-- Go to Edit Page -->
            <div class="col-sm-6">
                <form method="POST">
                    <button type="submit" name="goToEditPage" class="infoButtons p-3"> Hotel</button>
                </form>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="row">
            <!-- Delete Button -->
            <div class="col-sm-6">
                <form method="GET" action="viewAllInfo.php">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    <button type="submit" name="deleteUserButton" class="infoButtons p-3"> Bookings </button>
                </form>
                <?php deleteUserFinal(); ?>
            </div>

        </div>
    </div>


</body>

</html>