<?php
session_start();
require '../functions.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>View Info</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/editProfile.css'>
</head>

<body>

    <form method="POST">
        <!-- Return Home Button -->
        <button type="submit" name="returntoHotelPage" class="tranBack"><img class="homeButton mx-3 mt-3"
                src="../../static/img/home.png" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-icons/home"></button>
    </form>

    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="row">
            
            <!-- Button which will get the userId -->
            <div class="col-sm-6">

                <form method="GET" action="viewUserInfo.php">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    <button name="viewInfo" type="submit" class="viewAllInfoButtons p-3">View Your Information </button>
                </form>
            </div>

            <!-- Go to Edit Page -->
            <div class="col-sm-6">
                <form method="POST">
                    <button type="submit" name="goToEditPage" class="viewAllInfoButtons p-3"> Edit Your
                        Information</button>
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
                    <button type="submit" name="deleteUserButton" class="viewAllInfoButtons p-3"> Delete Your
                        Account</button>
                </form>
                <?php deleteUserFinal(); ?>
            </div>

            <!-- Add new user button -->
            <div class="col-sm-6">
                <form method="POST">
                    <button type="submit" name="newUserButton" class="viewAllInfoButtons p-3"> Add New User</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>