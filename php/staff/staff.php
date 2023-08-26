<?php
session_start();
require '../functions.php';

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
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/staff.css'>
</head>

<body>

<!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="staffReturnHome" class="home p-3 mx-3 my-3"> Home</button>
    </form>

    <?php echo "<h1> Greetings, $staffFullName! </h1>"; ?>

    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="background p-3">
            <?php echo "<h3> You have the role: {$_SESSION['role']} </h3>"; ?>
        </div>
    </div>


    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="row">

            <!-- Staff can View User Information -->
            <div class="col-sm-6">
                <form method="POST">
                    <button name="staffViewInfo" type="submit" class="infoButtons p-3">Users </button>
                </form>
            </div>

            <!-- Staff can View Hotel Information -->
            <div class="col-sm-6">
                <form method="POST">
                    <button type="submit" name="staffViewHotels" class="infoButtons p-3"> Hotel</button>
                </form>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-center align-items-center my-5">
        <div class="row">
            <!-- Bookings Button -->
            <div class="col-sm-6">
                <form method="POST">
                    <button type="submit" name="staffBookingView" class="infoButtons p-3"> Bookings </button>
                </form>
            </div>

            <div class="col-sm-6">
                <?php
                // If the employee is Admin, then they can add a new employee.
                if ($_SESSION['role'] === "Admin") {
                    $button = <<<DELIMETER
                    <form method="POST" action="viewStaff.php">
                        <button type="submit" name="viewEmployees" class="infoButtons p-3"> Employees </button>
                    </form>'
                    DELIMETER;
                    echo $button;
                }
                ?>
            </div>

        </div>
    </div>


</body>

</html>